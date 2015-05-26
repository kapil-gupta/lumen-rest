<?php

namespace App\Http\Controllers\OAuth;
use App\Http\Controllers\BaseController as BaseController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends BaseController {

    public function attemptLogin(Request $request) 
    {
    	$credentials = $request->input('credentials');
        return $this->proxy('password', $credentials);
    }

    public function attemptRefresh(Request $request)
    {
        $crypt = app()->make('encrypter');
        //$request = app()->make('request');
        
        return $this->proxy('refresh_token', [
            'refresh_token' => $crypt->decrypt($request->cookie('refreshToken'))
        ]); 
    }

    private function proxy($grantType, array $data = []) 
    {
        try {
            $config = app()->make('config');

            $data = array_merge([
                'client_id'     => $config->get('secrets.client_id'),
                'client_secret' => $config->get('secrets.client_secret'),
                'grant_type'    => $grantType
            ], $data);

            $client = new Client();
            $guzzleResponse = $client->post(sprintf('%s/oauth/access-token', $config->get('app.url')), [
                'body' => $data
            ]);
        } catch(\GuzzleHttp\Exception\BadResponseException $e) {
            $guzzleResponse = $e->getResponse();
            
        }

        $response = $guzzleResponse->json();

        if (isset($response['access_token'])) {
            $cookie = app()->make('cookie');
            $crypt  = app()->make('encrypter');

            $encryptedToken = $crypt->encrypt($response['refresh_token']);

            // Set the refresh token as an encrypted HttpOnly cookie
            $cookie->queue('refreshToken', 
                $crypt->encrypt($response['refresh_token']),
                604800, // expiration, should be moved to a config file
                null, 
                null, 
                false, 
                true // HttpOnly
            );

            $response = [
                'accessToken'            => $response['access_token'],
                'accessTokenExpiration'  => $response['expires_in']
            ];
        }

        $response = response()->json($response);
        $response->setStatusCode($guzzleResponse->getStatusCode());

        $headers = $guzzleResponse->getHeaders();
        foreach($headers as $headerType => $headerValue) {
            $response->header($headerType, $headerValue);
        }

        return $response;
    }
    public function getAccessToken(){
    	$authorizer  =app()->make('oauth2-server.authorizer');
    	return response()->json($authorizer->issueAccessToken());
    }

}
?>
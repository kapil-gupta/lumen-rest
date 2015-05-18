<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller {
	protected $api_prefix;
	protected $site_url;
	public function __construct() {
		 
		$this->api_prefix = config ( 'constants.api_prefix' );
		$this->site_url = config ( 'session.domain' );
	}
	public function getApiPrefix() {
		return $this->api_prefix;
	}
	public function getSiteUrl() {
		return $this->site_url;
	}
	public function getFullApiUrl(){
		return $this->site_url."/".$this->api_prefix;
	}
	protected function createdResponse($data)
	{
		$response = [
				'code' => 201,
				'status' => 'succcess',
				'data' => $data
		];
		return response()->json($response, $response['code']);
	}
	
	protected function showResponse($data)
	{
		$response = [
				'code' => 200,
				'status' => 'succcess',
				'data' => $data
		];
		return response()->json($response, $response['code']);
	}
	
	protected function listResponse($data)
	{
		$response = [
				'code' => 200,
				'status' => 'succcess',
				'data' => $data
		];
		return response()->json($response, $response['code']);
	}
	
	protected function notFoundResponse()
	{
		$response = [
				'code' => 404,
				'status' => 'error',
				'data' => 'Resource Not Found',
				'message' => 'Not Found'
		];
		return response()->json($response, $response['code']);
	}
	
	protected function deletedResponse()
	{
		$response = [
				'code' => 204,
				'status' => 'success',
				'data' => [],
				'message' => 'Resource deleted'
		];
		return response()->json($response, $response['code']);
	}
}

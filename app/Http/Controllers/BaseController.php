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
	 
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hackforums{

	private $ci;

	private $api_key;
	private $api_url;
	private $api_useragent;

	private $throw_error;

	public function __construct(){
		$this->ci =& get_instance();
		$this->ci->config->load('hackforums');

		$this->api_key 			= $this->ci->config->item('api_key');
		$this->api_url 			= $this->ci->config->item('api_url');
		$this->api_useragent 	= $this->ci->config->item('api_useragent');
		$this->throw_error 		= $this->ci->config->item('throw_api_errors');

		if(empty($this->api_key) OR empty($this->api_url) OR empty($this->api_useragent)){
			throw new Exception('Invalid configuration file, Please make sure everything is filled in');
		}
		
	}

	public function user($id){
		return $this->api_call('user/' . $id);
	}

	public function category($id){
		return $this->api_call('category/' . $id);
	}

	public function post($id){
		return $this->api_call('post/' . $id);
	}

	public function thread($id){
		return $this->api_call('thread/' . $id);
	}

	public function forum($id){
		return $this->api_call('forum/' . $id);
	}

	public function pm($id){
		return $this->api_call('pm/' . $id);
	}

	public function pmbox($id = null){
		if(!isset($id)){
			return $this->api_call('inbox/');
		}else{
			return $this->api_call('pmbox/' . $id);
		}
	}

	public function group($id){
		return $this->api_call('group/' . $id);
	}

	public function users($id){
		return $this->api_call('users/' . $id);
	}


	private function api_call($request){
		$headers = array(
		    'Content-Type:application/json',
		    'Authorization: Basic '. base64_encode($this->api_key . ":")
		);

		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $this->api_url . $request,
		    CURLOPT_USERAGENT => $this->api_useragent,
		    CURLOPT_SSL_VERIFYHOST => 0,
		    CURLOPT_SSL_VERIFYPEER => 0,
		    CURLOPT_HTTPHEADER => $headers
		));
		$data = json_decode(curl_exec($curl));
		curl_close($curl);

		if($this->throw_error AND !$data->success){
			throw new Exception("Hackforums API Error: " . $data->message);
		}else{
			return $data;
		}
	}

}
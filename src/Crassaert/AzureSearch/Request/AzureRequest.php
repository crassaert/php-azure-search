<?php
/**
 * @Author: cedric
 * @Date:   2015-11-17 11:27:42
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-17 16:17:23
 */

namespace Crassaert\AzureSearch\Request;

class AzureRequest {

	protected $url;
	protected $key;
	protected $version;
	protected $debug;

	public function __construct($url, $key, $debug = true, $version = '2015-02-28')
	{
		$this->url = $url;
		$this->key = $key;
		$this->version = $version;
		$this->debug = $debug;
	}

	public function request($path, $method = 'GET', $options = array())
	{
		$http_options = array('api-version' => $this->version);

		$curl = curl_init($this->url . '/' . $path . '?' . http_build_query($http_options));

		//curl_setopt($curl, CURLOPT_HEADER, $this->debug);
		curl_setopt($curl, CURLOPT_SSLVERSION, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_VERBOSE, $this->debug);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

		$this->setRequestData($curl, $method, $options);

		($this->debug) ?
		print "[[Debug: \nReq: ".curl_getinfo($curl, CURLINFO_HEADER_OUT) : $t=1;

		//curl_setopt_array($curl, $options);
		$result = curl_exec($curl);
		curl_close($curl);
		($this->debug) ? print "\nRes: $result]]\n" : $t=1;

		return json_decode($result);
	}

	protected function setRequestData(&$curl, $method, $options)
	{
		$headers = array();

		if ($method == 'POST' || $method == 'PUT')
		{                                        
			$data = json_encode($options);

			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Content-Length: ' . strlen($data);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		$headers[] = 'api-key:' . $this->key;
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);  
	}
}
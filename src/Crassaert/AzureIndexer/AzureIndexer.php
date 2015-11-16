<?php
/**
 * @Author: cedric
 * @Date:   2015-11-16 14:44:38
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-16 17:59:18
 */

namespace Crassaert\AzureIndexer;

class AzureIndexer {

	protected $url;
	protected $key;

	/*
	*
	*  Constructor
	*  Takes 2 parameters :
	*  URL : Your url .search.windows.net
	*  Key : Your primary key
	*
	*/
	public function __construct($url, $key, $debug = true, $version = '2015-02-28')
	{
		$this->url = $url;
		$this->key = $key;
		$this->version = $version;
		$this->debug = $debug;
	}

	// Data source creation
	// https://msdn.microsoft.com/fr-fr/library/azure/dn946876.aspx
	public function createSource($datasource, $options)
	{
		return $this->request('datasources', 'POST', $options);
	}

	// Data source update
	// https://msdn.microsoft.com/fr-FR/library/azure/dn946900.aspx
	public function updateSource($datasource, $options)
	{
		return $this->request('datasources/' . $datasource, 'PUT', $options);
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn946878.aspx
	public function listSources()
	{
		return $this->request('datasources', 'GET');
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn946893.aspx
	public function getSource($datasource)
	{
		return $this->request('datasources/' . $datasource, 'GET');
	}

	public function deleteSource($datasource)
	{
		return $this->request('datasources/' . $datasource, 'DELETE');
	}

	public function createIndexer($indexerName, $options)
	{
		$this->request('indexers', 'POST', $options);
	}

	public function updateIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName, 'PUT');
	}

	public function listIndexers()
	{
		return $this->request('indexers', 'GET');
	}

	public function getIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName, 'GET');
	}

	public function deleteIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName, 'DELETE');
	}

	public function executeIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName . '/run', 'POST');
	}

	public function statusIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName . '/status', 'GET');
	}

	public function resetIndexer($indexerName)
	{
		return $this->request('indexers/' . $indexerName . '/reset', 'POST');
	}

	protected function request($path, $method = 'GET', $options = array())
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

		return $result;
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
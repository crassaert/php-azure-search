<?php
/**
 * @Author: cedric
 * @Date:   2015-11-16 14:44:38
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-17 12:07:34
 */

namespace Crassaert\AzureSearch\Indexer;

use Crassaert\AzureSearch\Request\AzureRequest;

class AzureIndexer {
	
	protected $request;

	public function __construct(AzureRequest $request)
	{
		$this->request = $request;
	}

	public function createIndexer($indexerName, $options)
	{
		return $this->request->request('indexers', 'POST', $options);
	}

	public function updateIndexer($indexerName, $options)
	{
		return $this->request->request('indexers/' . $indexerName, 'PUT', $options);
	}

	public function listIndexers()
	{
		return $this->request->request('indexers', 'GET');
	}

	public function getIndexer($indexerName)
	{
		return $this->request->request('indexers/' . $indexerName, 'GET');
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn946898.aspx
	public function deleteIndexer($indexerName)
	{
		return $this->request->request('indexers/' . $indexerName, 'DELETE');
	}

	public function executeIndexer($indexerName)
	{
		return $this->request->request('indexers/' . $indexerName . '/run', 'POST');
	}

	public function statusIndexer($indexerName)
	{
		return $this->request->request('indexers/' . $indexerName . '/status', 'GET');
	}

	public function resetIndexer($indexerName)
	{
		return $this->request->request('indexers/' . $indexerName . '/reset', 'POST');
	}
}
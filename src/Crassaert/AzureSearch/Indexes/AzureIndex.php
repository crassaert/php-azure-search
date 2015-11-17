<?php
/**
 * @Author: cedric
 * @Date:   2015-11-17 11:34:07
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-17 12:31:38
 */

namespace Crassaert\AzureSearch\Indexes;

use Crassaert\AzureSearch\Request\AzureRequest;

class AzureIndex {

	protected $request;

	public function __construct(AzureRequest $request)
	{
		$this->request = $request;
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn798941.aspx
	public function createIndex($indexName, $options)
	{
		return $this->request->request('indexes', 'POST', $options);
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn800964.aspx
	public function updateIndex($indexName, $options)
	{
		return $this->request->request('indexes/' . $indexName, 'PUT', $options);
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn798923.aspx
	public function listIndex()
	{
		return $this->request->request('indexes', 'GET');
	}

	// https://msdn.microsoft.com/fr-fr/library/azure/dn798939.aspx
	public function getIndex($indexName)
	{
		return $this->request->request('indexes/' . $indexName, 'GET');
	}

	public function deleteIndex($indexName)
	{
		return $this->request->request('indexes/' . $indexName, 'DELETE');
	}
}
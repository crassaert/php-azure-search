<?php
/**
 * @Author: cedric
 * @Date:   2015-11-17 11:33:57
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-17 12:07:16
 */

namespace Crassaert\AzureSearch\Indexer;

use Crassaert\AzureSearch\Request\AzureRequest;

class AzureSource
{
	protected $request;

	public function __construct(AzureRequest $request)
	{
		$this->request = $request;
	}

	// Data source creation
	// https://msdn.microsoft.com/fr-fr/library/azure/dn946876.aspx
	public function createSource($datasource, $options)
	{
		return $this->request->request('datasources', 'POST', $options);
	}

	// Data source update
	// https://msdn.microsoft.com/fr-FR/library/azure/dn946900.aspx
	public function updateSource($datasource, $options)
	{
		return $this->request->request('datasources/' . $datasource, 'PUT', $options);
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn946878.aspx
	public function listSources()
	{
		return $this->request->request('datasources', 'GET');
	}

	// https://msdn.microsoft.com/fr-FR/library/azure/dn946893.aspx
	public function getSource($datasource)
	{
		return $this->request->request('datasources/' . $datasource, 'GET');
	}

	public function deleteSource($datasource)
	{
		return $this->request->request('datasources/' . $datasource, 'DELETE');
	}
}
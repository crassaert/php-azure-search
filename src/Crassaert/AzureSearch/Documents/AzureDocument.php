<?php
/**
 * @Author: cedric
 * @Date:   2015-11-17 11:33:57
 * @Last Modified by:   cedric
 * @Last Modified time: 2015-11-17 16:16:57
 */

namespace Crassaert\AzureSearch\Document;

use Crassaert\AzureSearch\Request\AzureRequest;

class AzureDocument
{
	protected $request;

	public function __construct(AzureRequest $request)
	{
		$this->request = $request;
	}

	/* Document management
	 * https://msdn.microsoft.com/fr-FR/library/azure/dn798930.aspx
	 *
	 * $options :
	 *   value (array):  
	 *     @search.action : upload | merge | mergeOrUpload | delete
	 *     "key_field_name": "unique_key_of_document"
	 *
	 */

	public function manageDocument($document, $options)
	{
		return $this->request->request('indexes/' . $document . '/docs/index', 'POST', $options);
	}

	/*
	 * Document search
	 * https://msdn.microsoft.com/fr-FR/library/azure/dn798927.aspx
	 *
	 */
	public function searchDocument($document, $options)
	{
		return $this->request->request('indexes/' . $document . '/docs/search', 'POST', $options);
	}
}
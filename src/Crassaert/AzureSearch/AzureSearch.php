<?php

namespace Crassaert\AzureSearch;

use Crassaert\AzureSearch\Indexer\AzureSource;
use Crassaert\AzureSearch\Indexer\AzureIndexer;
use Crassaert\AzureSearch\Indexes\AzureIndex;
use Crassaert\AzureSearch\Request\AzureRequest;


class AzureSearch {

	protected $request;
	protected $source_request;
	protected $indexer_request;
	protected $index_request;

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
		$this->request = new AzureRequest($url, $key, $debug, $version);
		$this->source_request = new AzureSource($this->request);
		$this->indexer_request = new AzureIndexer($this->request);
		$this->index_request = new AzureIndex($this->request); 
	}

	public function getSourceRequest()
	{
		return $this->source_request;
	}

	public function getIndexerRequest()
	{
		return $this->indexer_request;
	}

	public function getIndexRequest()
	{
		return $this->index_request;
	}

}
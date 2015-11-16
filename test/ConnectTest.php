<?php

require dirname(__FILE__) . '/config.php';
require dirname(__FILE__) . '/../vendor/autoload.php';

use Crassaert\AzureIndexer\AzureIndexer;

class ConnectTest extends PHPUnit_Framework_TestCase
{
	public function testConnection()
	{
		$indexer = new AzureIndexer(AZURE_SEARCH_HOST, AZURE_SEARCH_KEY, false);
		$sources = $indexer->listSources();

		$creation = $indexer->createSource('actions', 
									  array('name' => 'actions',
											'type' => 'documentdb',
											'credentials' => array('connectionString' => AZURE_DB_CONNECT_STRING),
											'container' => array('name' => 'user_actions')));

		$creation = $indexer->createIndexer('actions', 
									  array('name' => 'actions',
											'dataSourceName' => 'actions',
											'container' => array('name' => 'user_actions')));
	}
}
<?php

require dirname(__FILE__) . '/config.php';
require dirname(__FILE__) . '/../vendor/autoload.php';

use Crassaert\AzureSearch\AzureSearch;

class ConnectTest extends PHPUnit_Framework_TestCase
{
	public function testConnection()
	{
		$search = new AzureSearch(AZURE_SEARCH_HOST, AZURE_SEARCH_KEY, false);

		$this->log('Fetching current sources');
		$sources = $search->getSourceRequest()->listSources();

		$this->log('Updating source');

		$source = $search->getSourceRequest()->updateSource('actions', 
			array('name' => 'actions',
				'type' => 'documentdb',
				'credentials' => array('connectionString' => AZURE_DB_CONNECT_STRING),
				'container' => array('name' => 'user_actions')));
		$this->log($source);
		$this->log('Creating index');

		$fields = array();
		$fields[] = array('name' => 'id', 'type' => 'Edm.String', 'key' => true);
		$fields[] = array('name' => 'token', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'label', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'user_id', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'network_animal_id', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'publish', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'thumb', 'type' => 'Edm.String', 'key' => false);
		$fields[] = array('name' => 'description', 'type' => 'Edm.String', 'key' => false, 'filterable' => false, 'sortable' => false, 'facetable' => false);
		$fields[] = array('name' => 'created_at', 'type' => 'Edm.String', 'key' => false);

		$idx = $search->getIndexRequest()->updateIndex('actions',
			array('name' => 'actions',
				  'fields' => $fields)
			);

		$this->log($idx);
		var_dump($idx);
		$this->log('Creating indexer');

		$indexer = $search->getIndexerRequest()->updateIndexer('actions', 
			array('name' => 'actions',
				'dataSourceName' => 'actions',
				'targetIndexName' => 'actions',
				'schedule' => array('interval' => 'PT2H', 'startTime' => date('c'))));
		var_dump($indexer);
		$this->log($indexer);

		$data = $search->getDocumentRequest()->searchDocument('actions',
            array(
                'search' => 'PanterA'
                )
            );
		var_dump($data);
	}

	private function log($msg)
	{
		echo ">> " . $msg . "\n";
	}
}
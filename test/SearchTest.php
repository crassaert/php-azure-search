<?php

require dirname(__FILE__) . '/config.php';
require dirname(__FILE__) . '/../vendor/autoload.php';

use Crassaert\AzureSearch\AzureSearch;

class SearchTest extends PHPUnit_Framework_TestCase
{
	public function testConnection()
	{
		$search = new AzureSearch(AZURE_SEARCH_HOST, AZURE_SEARCH_KEY, false);
		
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
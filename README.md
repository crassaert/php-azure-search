# php-azure-search-indexer

PHP wrapper to query Microsoft Azure Search REST API by Cédric Rassaert.

It's strongly recommanded to have a Microsoft SQL Server or Azure DocumentDB as data source.

# Basic Usage

New search instance :

`$search = new AzureSearch(AZURE_SEARCH_HOST, AZURE_SEARCH_KEY);`

with :

```
AZURE_SEARCH_HOST = https://[service name].search.windows.net
AZURE_SEARCH_KEY = Admin key provided by Azure
```

## Add a datasource

Feel free to use your Microsoft SQL or DocumentDB host.

`
$search->getSourceRequest()->createSource('actions', 
			array('name' => 'my_source',
				  'type' => 'documentdb', // azuresql or documentdb
				  'credentials' => array('connectionString' => AZURE_DB_CONNECT_STRING),
				  'container' => array('name' => AZURE_DB_CONTAINER_NAME)));
`

## Add an index

You can add many fields into your index

```
$fields = array();
$fields[] = array('name' => 'id', 'type' => 'Edm.String', 'key' => true);
$fields[] = array('name' => 'name', 'type' => 'Edm.String', 'key' => false);

$search->getIndexRequest()->createIndex('my_index',
			array('name' => 'my_index',
			'fields' => $fields));
```

## Add an indexer

```
$search->getIndexerRequest()->updateIndexer('actions', 
			array(
				'name' => 'actions',
				'dataSourceName' => 'my_source',
				'targetIndexName' => 'my_index',
				'schedule' => array('interval' => 'PT30M', 'startTime' => date('c'))));
```

## Searching

```
$data = $search->getDocumentRequest()->searchDocument('my_index',
			array(
				'search' => 'my search string'
				)
			);
```

You can find all options on [Microsoft Azure Website](https://msdn.microsoft.com/fr-fr/library/azure/dn798935.aspx)
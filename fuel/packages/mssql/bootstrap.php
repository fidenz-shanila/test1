<?php

Autoloader::add_core_namespace('MSSQL');

Autoloader::add_classes(array(

	'MSSQL\\Connection'							=> __DIR__.'/connection.php',
	'MSSQL\\Db'					=> __DIR__.'/db.php',
	'MSSQL\\Msql_Driver'					=> __DIR__.'/driver.php',

	
));
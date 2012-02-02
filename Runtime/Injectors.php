<?php
/**
 *
 *===================================================================
 *
 *  Shot Library
 *-------------------------------------------------------------------
 * @package     shot
 * @author      emberlabs.org
 * @copyright   (c) 2012 emberlabs.org
 * @license     MIT License
 * @link        https://github.com/emberlabs/shot
 *
 *===================================================================
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 *
 */

namespace emberlabs\shot\Runtime;
use \emberlabs\shot\WebKernel;
use \emberlabs\openflame\Core\DependencyInjector;
use \emberlabs\openflame\Core\Internal\FileException;
use \emberlabs\openflame\Core\Internal\RuntimeException;
use \OpenFlame\Dbal\Connection as DbalConnection;
use \OpenFlame\Dbal\Query;
use \OpenFlame\Dbal\QueryBuilder;

$injector = DependencyInjector::getInstance();

// bit of a trick to trigger lazy dbal connection creation
$injector->setInjector('dbal', function() {
	$kernel = WebKernel::getInstance();

	$dsn = $username = $password = $db_options = NULL;
	switch($kernel['db.type'])
	{
		case 'sqlite':
			if(!isset($kernel['db.file']))
			{
				throw new FileException('No database file specified for sqlite database connection');
			}
			$dsn = sprintf('sqlite:%s', $kernel['db.file']);
		break;

		case 'mysql':
		case 'mysqli': // in case someone doesn't know that pdo doesn't do mysqli
			if(!isset($kernel['db.name']) || !isset($kernel['db.user']))
			{
				throw new RuntimeException('Missing or invalid database connection parameters, cannot connect to database');
			}
			$dsn = sprintf('mysql:charset=utf8;host=%s;dbname=%s', ($kernel['db.host'] ?: 'localhost'), $kernel['db.name']);
			$username = $kernel['db.user'];
			$password = $kernel['db.password'] ?: '';
			$db_options = array(
				\PDO::MYSQL_ATTR_INIT_COMMAND		=> 'SET NAMES utf8',
				\PDO::MYSQL_ATTR_FOUND_ROWS			=> true,
			);
		break;

		case 'pgsql':
		case 'postgres':
		case 'postgresql':
			if(!isset($kernel['db.name']) || !isset($kernel['db.user']))
			{
				throw new RuntimeException('Missing or invalid database connection parameters, cannot connect to database');
			}
			$dsn = sprintf('pgsql:host=%s;dbname=%s', ($kernel['db.host'] ?: 'localhost'), $kernel['db.name']);
			$username = $options['db.user'];
			$password = $options['db.password'] ?: '';
		break;

		default:
			throw new RuntimeException('Invalid or unsupported database type specified for connection');
		break;
	}

	DbalConnection::getInstance()
		->connect($dsn, $username, $password, $db_options);

	return true;
});

$injector->setInjector('query', function() use($injector) {
	$injector->get('dbal');
	return Query::newInstance();
});

$injector->setInjector('querybuilder', function() use($injector) {
	$injector->get('dbal');
	return QueryBuilder::newInstance();
});

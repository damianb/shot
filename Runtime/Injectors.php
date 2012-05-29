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
use \emberlabs\openflame\Core\Autoloader;
use \emberlabs\openflame\Core\DependencyInjector;
use \emberlabs\shot\Controller\CachedController;
//use \emberlabs\shot\Controller\InstallerController;
use \emberlabs\shot\WebKernel as App;

if(!defined('SHOT_ROOT')) exit;

$injector = DependencyInjector::getInstance();

$injector->setInjector('cookie', function() {
	$app = App::getInstance();
	$cookie = new \emberlabs\openflame\Header\Helper\Cookie\Manager();
	if($app['cookie.domain'])
	{
		$cookie->setCookieDomain($app['cookie.domain']);
	}
	if($app['cookie.path'])
	{
		$cookie->setCookiePath($app['cookie.path']);
	}
	if($app['cookie.prefix'])
	{
		$cookie->setCookiePrefix($app['cookie.prefix'] . '_');
	}

	return $cookie;
});

$injector->setInjector('stat', '\\emberlabs\\shot\\Stat');
$injector->setInjector('session', '\\emberlabs\\shot\\Session\\Session');
$injector->setInjector('controller.cached', function() {
	$app = App::getInstance();

	return new CachedController($app, $app->request, $app->response);
});
/*
$injector->setInjector('controller.installer', function() {
	$app = App::getInstance();

	return new InstallerController($app, $app->request, $app->response);
});
*/

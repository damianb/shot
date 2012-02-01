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
use \emberlabs\shot\Kernel;
use \emberlabs\shot\Page\Request;
use \emberlabs\openflame\Core\Autoloader;
use \emberlabs\openflame\Core\Utility\JSON;
use \emberlabs\openflame\Event\Instance as Event;
use \emberlabs\openflame\Exception\EncryptedHandler as ExceptionHandler;

/**
 * page preparation listeners
 */

Kernel::register('shot.page.prepare', 0, function(Event $event) {
	// asdf
});

Kernel::register('shot.page.prepare.language', 0, function(Event $event) {
	$language = Kernel::get('language');
	if(Kernel::getConfig('shot.language.entries'))
	{
		$language->loadEntries(Kernel::getConfig('shot.language.entries'));
	}
	elseif(Kernel::getConfig('shot.language.file'))
	{
		$language->loadEntries(JSON::decode(Kernel::getConfig('shot.language.file')));
	}
});

/**
 * page execution listeners
 */

Kernel::register('shot.page.excecute.controller', 0, function(Event $event) {
	$_SERVER; // have to poke the _SERVER superglobal for it to be usable in $_GLOBALS sometimes. possible php bug, idk.
	$router = Kernel::get('router');

	$request = Kernel::get('input')->getInput('SERVER::REQUEST_URI', '/');
	if(!$request->wasSet())
	{
		$request = Kernel::get('input')->getInput('REQUEST::QUERY_URI', '/');
	}

	$uri = $request->getClean();

	try {
		$route = $router->processRequest($uri);

		$request = new Request();
		$request->setURI($uri)
			->setRoute($route);

		$controller = $route->getController();
		Kernel::setObject('shot.controller', $controller);

		$controller->before();
		$response = $controller->runController();
		$controller->after($response);
	}
	catch(RedirectException $e)
	{
		$event = Event::newEvent('shot.server.redirect')
			->set('location', $e->getMessage())
			->set('uri', $uri);

		Kernel::_trigger($event);
	}
	catch(ServerException $e)
	{
		$event = Event::newEvent('shot.server.error')
			->set('message', $e->getMessage())
			->set('code', $e->getCode())
			->set('uri', $uri);

		Kernel::_trigger($event, Kernel::TRIGGER_MIXEDBREAK);
	}
});

/**
 * Display listeners
 */

Kernel::register('shot.page.display', 0, function(Event $event) {
	// asdf
});

/**
 * The starting pistol.
 */

Kernel::register('shot.fire', 0, function(Event $event) {
	Kernel::mtrigger(array(
		'shot.page.pre',
		'shot.page.prepare.language',
		'shot.page.prepare.twig',
		'shot.page.prepare',
		'shot.page.execute.controller',
		'shot.page.execute',
		'shot.page.display',
		'shot.page.post',
	));
});

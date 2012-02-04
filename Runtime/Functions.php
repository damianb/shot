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
use \emberlabs\openflame\Event\Dispatcher;
use \emberlabs\openflame\Event\Instance as Event;
use \emberlabs\shot\WebKernel;

function hook($name, array &$data)
{
	$hook = Event::newEvent($name)
		->setData($data);

	$kernel = WebKernel::getInstance();
	$kernel->dispatcher->trigger($hook, Dispatcher::TRIGGER_MIXEDBREAK);

	$data = $hook->getData();
}

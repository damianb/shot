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

namespace emberlabs\shot\Hook;
use \emberlabs\openflame\Event\Dispatcher;
use \emberlabs\openflame\Event\Instance as Event;
use \emberlabs\shot\WebKernel;

/**
 * Shot - Hook instance object
 * 	     Provides a way to deploy hook points across a web application.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class Hook
	extends Event
{
	public static function fire($name, array &$data)
	{
		$hook = self::newEvent($name)
			->setData($data);

		$kernel = WebKernel::getInstance();
		$kernel->dispatcher->trigger($hook, Dispatcher::TRIGGER_MIXEDBREAK);

		$data = $hook->getData();
	}
}

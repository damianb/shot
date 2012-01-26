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

namespace emberlabs\shot;
use \emberlabs\shot\Kernel;
use \OpenFlame\Framework\Core\DependencyInjector;
use \OpenFlame\Framework\Event\Dispatcher;
use \OpenFlame\Framework\Event\Instance as Event;

/**
 * Shot - Web Kernel
 * 	     Provides shortcuts to commonly used web functionality.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class WebKernel
	implements ArrayAccess
{
	protected $app_seed, $session_seed, $base_path, $request, $response;

	/**
	 * Settings and stuff
	 */

	public function getVersion()
	{
		return Kernel::VERSION;
	}

	public function getBasePath()
	{
		// asdf
	}

	public function setBasePath($path)
	{
		// asdf
	}

	public function getApplicationSeed()
	{
		// asdf
	}

	public function setApplicationSeed($seed)
	{
		// asdf
	}

	public function getSessionSeed()
	{
		// asdf
	}

	public function setSessionSeed($seed)
	{
		// asdf
	}

	/**
	 * Site run methods
	 */

	public function boot()
	{
		// asdf
	}

	public function run()
	{
		// asdf
	}

	public function display()
	{
		// asdf
	}

	public function shutdown()
	{
		// asdf
	}

	/**
	 * Magic methods
	 */

	public function __get($field)
	{
		return Kernel::getObject($field);
	}

	public function __isset($field)
	{
		return (Kernel::getObject($field) !== NULL) ? true : false;
	}

	public function __set($field, $value)
	{
		if(!is_object($value))
		{
			return;
		}

		Kernel::setObject($field);
	}

	public function __toString()
	{
		return Kernel::VERSION;
	}

	/**
	 * ArrayAccess methods
	 */
	public function offsetExists($offset)
	{
		return (Kernel::getConfig($offset) !== NULL) ? true : false;
	}

	public function offsetGet($offset)
	{
		return Kernel::getConfig($offset);
	}

	public function offsetSet($offset, $value)
	{
		Kernel::setConfig($offset, $value);
	}

	public function offsetUnset($offset)
	{
		Kernel::setConfig($offset, NULL);
	}
}

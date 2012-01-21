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

namespace emberlabs\shot\Page;
use \emberlabs\shot\Kernel;
use \OpenFlame\Framework\Route\RouteInstance;

/**
 * Shot - Controller interface
 * 	     Provides controller prototype for controllers to fulfill.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class Request
{
	protected $method, $referer, $useragent, $ip, $uri, $route;

	public function __construct()
	{
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->referer = $_SERVER['HTTP_REFERER'];
		$this->useragent = $_SERVER['HTTP_USER_AGENT'];
		$this->ip = $_SERVER['REMOTE_ADDR'];
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getReferer()
	{
		return $this->referer;
	}

	public function getUseragent()
	{
		return $this->useragent;
	}

	public function getIP()
	{
		return $this->ip;
	}

	public function getURI()
	{
		return $this->uri;
	}

	public function setURI($uri)
	{
		$this->uri = (string) $uri;

		return $this;
	}

	public function getRoute()
	{
		return $this->route;
	}

	public function setRoute(RouteInstance $route)
	{
		$this->route = $route;

		return $this;
	}

	public function getInput($input, $default = '')
	{
		return Kernel::get('input')->getInput($input, $default)->getClean();
	}
}

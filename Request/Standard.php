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

namespace emberlabs\shot\Request;
use \emberlabs\shot\WebKernel;
use \emberlabs\openflame\Route\RouteInstance;

/**
 * Shot - Standard request object
 * 	     Handles and provides request data to controllers.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class Standard
	implements RequestInterface
{
	protected $method, $referer, $useragent, $ip, $uri, $route;

	public function __construct()
	{
		$kernel = WebKernel::getInstance();

		$this->method = $this->getInput('SERVER::REQUEST_METHOD', 'GET');
		$this->referer = $this->getInput('SERVER::HTTP_REFERER', '-');
		$this->useragent = $this->getInput('SERVER::HTTP_USER_AGENT', '-');
		$this->ip = $this->getInput('SERVER::REMOTE_ADDR', '127.0.0.1');
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

	public function getInput($input, $default)
	{
		$kernel = WebKernel::getInstance();
		return $kernel->input->getInput($input, $default)->getClean();
	}

	public function isAuthenticated()
	{
		return false;
	}
}

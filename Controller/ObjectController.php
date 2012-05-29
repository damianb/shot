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

namespace emberlabs\shot\Controller;
use \emberlabs\shot\WebKernel;
use \emberlabs\shot\Request\RequestInterface;
use \emberlabs\shot\Response\HTTP as HTTPResponse;
use \emberlabs\shot\Response\ResponseInterface;

/**
 * Shot - Object-based controller base
 * 	     Provides controller base for controller classes to build on top of.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
abstract class ObjectController
	implements ControllerInterface
{
	protected $app, $request, $response, $name, $auths;
	protected $bypass_install_check = false, $cacheable = false, $cache_ttl = 0;

	final public function __construct(WebKernel $app, RequestInterface $request, ResponseInterface $response)
	{
		$this->app = $app;
		$this->request = $request;
		$this->response = $response;
		$this->init();
	}

	protected function init() { }

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = (string) $name;

		return $this;
	}

	public function getRequiredAuths()
	{
		return $this->auths;
	}

	public function setRequiredAuths(array $auths)
	{
		$this->auths = $auths;

		return $this;
	}

	public function getInput($input, $default = '')
	{
		return $this->request->getInput($input, $default);
	}

	public function getRouteInput($input)
	{
		return $this->request->getRoute()->get($input);
	}

	public function wasInputSet($input)
	{
		return $this->app->input->getInput($input, false)->getWasSet();
	}

	public function respond($body, $http_status, array $vars = NULL)
	{
		$this->response->setResponseCode((int) $http_status);
		$this->response->setBody($body);
		if($vars)
		{
			$this->response->setTemplateVars($vars);
		}

		return $this->response;
	}

	public function before() { }

	abstract public function runController();

	public function after()
	{
		return $this->response;
	}

	final public function isCacheable()
	{
		return $this->cacheable;
	}

	final public function canRunWithoutInstall()
	{
		return $this->bypass_install_check;
	}

	protected function defineCacheBinds()
	{
		// this should probably be overridden by the child controller
		return array();
	}

	final public function getCacheBinds()
	{
		return array_merge($this->defineCacheBinds(), array(
			get_class($this),
		));
	}

	final public function getCacheTTL()
	{
		return (int) $this->cache_ttl;
	}
}

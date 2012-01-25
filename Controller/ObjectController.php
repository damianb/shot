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
use \emberlabs\shot\Kernel;
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
	protected $request, $name, $auths;

	public function __construct(RequestInterface $request)
	{
		$this->request = $request;
	}

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

	public function before() { }

	public function runController()
	{
		$response = new HTTPResponse();
		$response->setContentType('html');

		return $response;
	}

	public function after(ResponseInterface $response)
	{
		return $response;
	}
}

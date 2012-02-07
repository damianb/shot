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
use \emberlabs\openflame\Core\Internal\FileException;

/**
 * Shot - Include Controller
 * 	     Provides a crazily-easy way to create controllers.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class IncludeController
	implements ControllerInterface
{
	protected $app, $request, $name, $auths, $include_file, $objects;

	public function __construct(WebKernel $app, RequestInterface $request, ResponseInterface $response)
	{
		$this->app = $app;
		$this->request = $request;
		$this->response = $response;
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

	public function getIncludeFile()
	{
		return $this->include_file;
	}

	public function setIncludeFile($include_file)
	{
		if(!file_exists($include_file))
		{
			throw new FileException(sprintf('Controller include file "%s" does not exist', $include_file));
		}

		$this->include_file = $include_file;

		return $this;
	}

	public function getInjectedObjects()
	{
		return $this->objects;
	}

	public function setInjectedObjects(array $objects)
	{
		$this->objects = $objects;

		return $this;
	}

	public function before() { }

	public function runController()
	{
		// Assign scope variables for the controller
		$request = $this->request;

		if($this->getInjectedObjects())
		{
			extract(Kernel::mget($this->getInjectedObjects()), EXTR_OVERWRITE);
		}

		// Prepare the $response var - the include file can change stuff afterwards itself if it wants.
		$response = $this->response;
		$response->setContentType('html');

		$template = array();
		$template_name = '';

		require $this->getIncludeFile();

		$response->setTemplateVars($template)
			->setTemplate($template_name);

		return $response;
	}

	public function after()
	{
		return $this->response;
	}
}

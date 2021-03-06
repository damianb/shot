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
use \emberlabs\shot\Request\RequestInterface;
use \emberlabs\shot\Response\ResponseInterface;
use \emberlabs\shot\WebKernel;
use \emberlabs\openflame\Route\RouteInstance;

/**
 * Shot - Controller interface
 * 	     Provides controller prototype for controllers to fulfill.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
interface ControllerInterface
{
	public function __construct(WebKernel $app, RequestInterface $request, ResponseInterface $response);
	public function getName();
	public function setName($name);
	public function getRequiredAuths();
	public function setRequiredAuths(array $auths);
	public function before();
	public function after();
}

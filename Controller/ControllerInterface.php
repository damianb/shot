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
use \emberlabs\shot\Page\Request;
use \emberlabs\shot\Page\Response;
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
interface ControllerInterface
{
	public function __construct(Request $request);

	public function getName();

	public function setName($name);

	public function getRequiredAuths();

	public function setRequiredAuths(array $auths);

	public function before();

	public function runController();

	public function after(Response $response);
}

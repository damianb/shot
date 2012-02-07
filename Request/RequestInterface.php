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
use \emberlabs\shot\Kernel;
use \emberlabs\shot\Model\ModelBase;
use \emberlabs\openflame\Router\RouteInstance;

/**
 * Shot - Request interface
 * 	     Provides a prototype for request objects to fulfill.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
interface RequestInterface
{
	public function getMethod();
	public function getReferer();
	public function getUseragent();
	public function getIP();
	public function getURI();
	public function setURI($uri);
	public function getRoute();
	public function setRoute(RouteInstance $route);
	public function getInput($input, $default);
	public function isAuthenticated();
}

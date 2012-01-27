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

namespace emberlabs\shot\Response;
use \emberlabs\shot\Kernel;

/**
 * Shot - Response object
 * 	     Standard HTTP response object.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
interface ResponseInterface
{
	public function getContentType();
	public function setContentType($type);
	public function getHeaders();
	public function setHeader($header, $value);
	public function setHeaders(array $headers);
	public function getBody();
	public function setBody($body)
	public function getResponseCode();
	public function setResponseCode($code = 200);
	public function display();
}

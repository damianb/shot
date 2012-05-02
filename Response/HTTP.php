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
class HTTP
	implements ResponseInterface
{
	protected $t_vars, $content_type, $headers, $body, $use_templating;

	protected $response = 200;

	protected static $types = array(
		'plain'		=> 'text/plain',
		'json'		=> 'application/json',
		'xml'		=> 'application/xml',
		'html'		=> 'text/html',
		'xhtml'		=> 'application/xhtml+xml',
	);

	public function __construct()
	{
		$this->setContentType('html');
		$this->enableTemplating();
	}

	public function getContentType()
	{
		return $this->content_type;
	}

	public function setContentType($type)
	{
		if(isset(self::$types[$type]))
		{
			$this->content_type = self::$types[$type];
		}
		else
		{
			$this->content_type = $type;
		}
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function setHeader($header, $value)
	{
		$this->headers[(string) $header] = $value;

		return $this;
	}

	public function setHeaders(array $headers)
	{
		$this->headers = $headers;

		return $this;
	}

	public function getTemplateVars()
	{
		return $this->t_vars;
	}

	public function setTemplateVars(array $vars)
	{
		$this->t_vars = $vars;

		return $this;
	}

	public function isUsingTemplating()
	{
		return $this->use_templating;
	}

	public function enableTemplating()
	{
		$this->use_templating = true;

		return $this;
	}

	public function disableTemplating()
	{
		$this->use_templating = false;

		return $this;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setBody($body)
	{
		$this->body = (string) $body;

		return $this;
	}

	public function getResponseCode()
	{
		return $this->response;
	}

	public function setResponseCode($code = 200)
	{
		$this->response = (int) $code;

		return $this;
	}
}

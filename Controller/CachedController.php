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

if(!defined('SHOT_ROOT')) exit;

class CachedController
	extends ObjectController
{
	protected $cacheable = false, $cache = '';
	private $original_controller;

	public function setOriginalController(ObjectController $controller)
	{
		$this->original_controller = $controller;

		return $this;
	}

	public function loadCache($cache)
	{
		$this->cache = $cache;

		return $this;
	}

	public function runController()
	{
		$this->response->disableTemplating()
			->setHeader('X-App-Magic-Cache', 'HIT')
			->setContentType($this->cache['content_type'])
			->setResponseCode($this->cache['http_status'])
			->setBody($this->cache['body']);

		return $this->response;
	}
}

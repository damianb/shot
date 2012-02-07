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

namespace emberlabs\shot;
use \emberlabs\shot\Request\Standard as StandardRequest;
use \emberlabs\shot\Response\HTTP as HTTPResponse;
use \emberlabs\openflame\Core\Core;
use \emberlabs\openflame\Core\DependencyInjector;
use \emberlabs\openflame\Core\Utility\JSON;
use \ArrayAccess;

/**
 * Shot - Web Kernel
 * 	     Provides shortcuts to commonly used web functionality.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class WebKernel
	extends Core
	implements ArrayAccess
{
	private static $version = '1.0.0-dev';

	protected $injector, $app_seed, $session_seed, $base_path;

	public $request, $response;

	protected static $instances = array();

	public static function getInstance($instance = NULL)
	{
		$instance = ($instance === NULL) ? 'default' : '_' . $instance;

		if(!isset(self::$instances[$instance]))
		{
			self::$instances[$instance] = new self();
			self::$instances[$instance]->_init();
		}

		return self::$instances[$instance];
	}

	protected function __construct()
	{
		$this->injector = DependencyInjector::getInstance();
	}

	protected function _init()
	{
		$this->request = new StandardRequest();
		$this->response = new HTTPResponse();
	}

	public static function getShotVersion()
	{
		return self::$version;
	}

	public static function version()
	{
		return sprintf('shot v%s || of-f v%s', self::$version, parent::getVersion());
	}

	public function __toString()
	{
		return sprintf('shot v%s || of-f v%s', self::getShotVersion(), self::getVersion());
	}

	/**
	 * Settings and stuff
	 */

	public function getBasePath()
	{
		return $this->base_path;
	}

	public function setBasePath($path)
	{
		$this->base_path = $path;

		$this->router->setBaseURL($path);
		$this->asset->setBaseURL($path);
		$this->url->setBaseURL($path);

		return $this;
	}

	public function getApplicationSeed()
	{
		return $this->app_seed;
	}

	public function setApplicationSeed($seed)
	{
		$this->app_seed = $seed;
		$this->seeder->setApplicationSeed($seed);
		$this->form->setFormSeed($seed . '.' . $this->getSessionSeed());

		return $this;
	}

	public function getSessionSeed()
	{
		return $this->session_seed;
	}

	public function setSessionSeed($seed)
	{
		$this->session_seed = $seed;
		$this->seeder->setSessionSeed($seed);
		$this->form->setFormSeed($this->getApplicationSeed() . '.' . $seed);

		return $this;
	}

	/**
	 * Site run methods
	 */

	public function boot()
	{
		$config = JSON::decode(file_get_contents(SHOT_CONFIG_ROOT . '/config.json'));
		if(!empty($config))
		{
			foreach($config as $_k => $_v)
			{
				$this->offsetSet($_k, $_v);
			}

			// load extra config files
			if($this->offsetExists('shot.config.files'))
			{
				foreach($this->offsetGet('shot.config.files') as $file)
				{
					if(!file_exists(SHOT_CONFIG_ROOT . sprintf('/%s.json', basename($file, '.json'))))
					{
						continue;
					}

					$config = JSON::decode(SHOT_CONFIG_ROOT . sprintf('/%s.json', basename($file, '.json')));
					if(!empty($config))
					{
						foreach($config as $_k => $_v)
						{
							$this->offsetSet($_k, $_v);
						}
					}
				}
			}
			unset($config);
		}

		/*
		// load language entries
		if($this->offsetExists('shot.language.entries'))
		{
			$this->language->loadEntries($this->offsetGet('shot.language.entries'));
		}
		*/

		// snag headers
		$this->header->snagHeaders();

		// load routes
		if($this->offsetExists('shot.routes.entries'))
		{
			if($this->cache->dataCached('shot_routes'))
			{
				$this->router->loadFromFullRouteCache($this->cache->loadData('shot_routes'));
			}
			else
			{
				// Define routes
				$routes = $this->offsetGet('shot.routes.entries');

				$this->router->newRoutes($routes);

				$home = $this->router->newRoute($routes['home']['path'], $routes['home']['callback']);
				$this->router->storeRoute($home)
					->setHomeRoute($home);

				$error = $this->router->newRoute($routes['error']['path'], $routes['error']['callback']);
				$this->router->storeRoute($error)
					->setErrorRoute($error);

				//$this->cache->storeData('shot_routes', $this->router->getFullRouteCache());
			}
		}
		unset($routes, $home, $error);
	}

	public function run()
	{
		$_SERVER; // have to poke the _SERVER superglobal for it to be usable in $_GLOBALS sometimes. possible php bug, idk.

		$request = $this->input->getInput('SERVER::REQUEST_URI', '/');
		if(!$request->getWasSet())
		{
			$request = $this->input->getInput('REQUEST::QUERY_URI', '/');
		}

		$uri = $request->getClean();

		$route = $this->router->processRequest($uri);

		$this->request->setURI($uri)
			->setRoute($route);

		$controller = $this->injector->getInjector($route->getRouteCallback());
		$this->controller = new $controller($this->request, $this->response);

		$controller->before();
		$this->response = $controller->runController();
		$controller->after();
	}

	public function display()
	{
		try
		{
			ob_start();
			if($this->response->usingTemplates())
			{
				// load assets
				if($this->offsetExists('shot.assets.entries'))
				{
					foreach($this->offsetGet('shot.assets.entries') as $type => $_assets)
					{
						foreach($_assets as $asset_name => $asset_url)
						{
							$this->asset->registerCustomAsset($type, $asset_name)
								->setURL($asset_path . '/' . $type . '/' . $asset_url);
						}
					}
				}

				// load urls
				if($this->offsetExists('shot.urls.entries'))
				{
					foreach($this->offsetGet('shot.urls.entries') as $name => $pattern)
					{
						$this->url->newPattern($name, $pattern);
					}
				}

				// prepare twig
				$twig_env = $this->twig->getTwigEnvironment();
				$twig_env->addGlobal('timer', $this->timer);
				$twig_env->addGlobal('asset', $this->asset_proxy);
				$twig_env->addGlobal('language', $this->language_proxy);
				$twig_env->addGlobal('url', $this->url_proxy);

				$twig_page = $twig_env->loadTemplate($this->response->getBody());

				$body = $twig_page->render($this->response->getTemplateVars());
			}
			else
			{
				$body = $this->response->getBody();
			}

			echo $body;

			// Set our content-length header, and send all headers.
			$this->header->setHeader('Content-Length', ob_get_length());
			$this->header->sendHeaders();
			ob_end_flush();
		}
		catch(\Exception $e)
		{
			ob_clean();
			throw $e;
		}
	}

	public function shutdown() { }

	/**
	 * Magic methods
	 */

	public function __get($field)
	{
		return $this->injector->get($field);
	}

	public function __isset($field)
	{
		return (parent::getObject($field) !== NULL) ? true : false;
	}

	public function __set($field, $value)
	{
		parent::setObject($field);
	}

	/**
	 * ArrayAccess methods
	 */
	public function offsetExists($offset)
	{
		return (parent::getConfig($offset) !== NULL) ? true : false;
	}

	public function offsetGet($offset)
	{
		return parent::getConfig($offset);
	}

	public function offsetSet($offset, $value)
	{
		parent::setConfig($offset, $value);
	}

	public function offsetUnset($offset)
	{
		parent::setConfig($offset, NULL);
	}
}

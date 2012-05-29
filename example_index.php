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

use \emberlabs\shot\WebKernel as App;

define('SHOT_DEBUG', true);
define('SHOT_IN_PHAR', false);
define('APP_IN_PHAR', false);

define('SHOT_ROOT', dirname(__DIR__));
define('SHOT_ADDON_ROOT', SHOT_ROOT . '/app/addons');
define('SHOT_CONFIG_ROOT', SHOT_ROOT . '/config');
define('SHOT_LANGUAGE_ROOT', SHOT_ROOT . '/app/language');
define('SHOT_LIB_ROOT', SHOT_ROOT . '/app/src');
define('SHOT_INCLUDE_ROOT', SHOT_ROOT . '/app/src');
define('SHOT_VENDOR_ROOT', SHOT_ROOT . '/app/vendor');
define('SHOT_VIEW_ROOT', SHOT_ROOT . '/app/views');

define('APP_NAMESPACE', 'example\\app');
define('SHOT_CORE_PHAR', 'shot.phar');
define('APP_CORE_PHAR', 'example_app.phar');

define('_APP_PATH', '/' . str_replace('\\', '/', APP_NAMESPACE));
define('_SHOT_MAGIC_LOAD_DIR', (!SHOT_IN_PHAR) ? SHOT_INCLUDE_ROOT : sprintf('phar://%s/%s.phar', SHOT_LIB_ROOT, SHOT_CORE_PHAR));
define('_APP_MAGIC_LOAD_DIR', (!APP_IN_PHAR) ? SHOT_INCLUDE_ROOT : sprintf('phar://%s/%s.phar', SHOT_LIB_ROOT, APP_CORE_PHAR));

require _SHOT_MAGIC_LOAD_DIR . '/emberlabs/shot/Runtime/Bootstrap.php';

$app = App::getInstance();

$app->boot();
$app->run();
$app->display();
$app->shutdown();

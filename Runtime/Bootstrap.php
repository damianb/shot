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

namespace emberlabs\shot\Runtime;
use \emberlabs\shot\Kernel;
use \emberlabs\openflame\Core\Autoloader;
use \emberlabs\openflame\Core\Internal\RequirementException;
use \emberlabs\openflame\Core\Utility\JSON;
use \emberlabs\openflame\Exception\EncryptedHandler as ExceptionHandler;
use \OpenFlame\Dbal\Connection as DbalConnection;

// get error reporting stuff
$_e_reporting = @error_reporting();

define('SHOT_LOAD_START', microtime(true));

if(!defined('SHOT_INCLUDE_ROOT'))
{
	die('Required constant "SHOT_INCLUDE_ROOT" not defined');
}
if(!defined('SHOT_ROOT'))
{
	die('Required constant "SHOT_ROOT" not defined');
}

// defaults
$_defaults = array(
	'SHOT_DEBUG'					=> false,
	'SHOT_DEBUG_SHOW_CONTEXT'		=> false,
	'SHOT_DEBUG_UNWRAP'				=> 0,
	'SHOT_CONFIG_PATH'				=> SHOT_ROOT . 'config/',
);
foreach($_defaults as $_const => $_default)
{
	if(!defined($_const))
	{
		define($_const, $_default);
	}
}

// set up autoloader
require SHOT_INCLUDE_ROOT . 'emberlabs/openflame/Core/Autoloader.php';
Autoloader::register(SHOT_INCLUDE_ROOT);

// Force full debug on here
@error_reporting(E_ALL);
@ini_set("display_errors", "On");

// check for blocking requirements
if(@ini_get('register_globals'))
{
	throw new RequirementException('Application will not run with register_globals enabled; please disable register_globals to run this application.');
}
if(@get_magic_quotes_gpc())
{
	throw new RequirementException('Application will not run with magic_quotes_gpc enabled; please disable magic_quotes_gpc to run this application.');
}
if(@get_magic_quotes_runtime())
{
	throw new RequirementException('Application will not run with magic_quotes_runtime enabled; please disable magic_quotes_runtime to run this application.');
}

// load special runtime files
require SHOT_INCLUDE_ROOT . 'emberlabs/shot/Runtime/Functions.php';
require SHOT_INCLUDE_ROOT . 'emberlabs/shot/Runtime/Injectors.php';
//require SHOT_INCLUDE_ROOT . 'emberlabs/shot/Runtime/Listeners.php';

// do we leave debug on, or...
if(!SHOT_DEBUG)
{
	@error_reporting($_e_reporting);
	@ini_set("display_errors", "Off");
}

unset($_e_reporting, $_defaults, $_const, $_default);

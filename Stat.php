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

class Stat
{
	public function server()
	{
		$name = explode('.', php_uname('n'));
		return strtolower(array_shift($name));
	}

	public function time()
	{
		return round(microtime(true) - SHOT_LOAD_START, 5);
	}

	public function mem()
	{
		return \emberlabs\shot\Runtime\formatBytes(memory_get_usage(), 2);
	}

	public function memPeak()
	{
		return \emberlabs\shot\Runtime\formatBytes(memory_get_peak_usage(), 2);
	}
}

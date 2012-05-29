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

namespace emberlabs\shot\Model;
use \emberlabs\openflame\Core\Utility\JSON;
use \RedBean_SimpleModel;

if(!defined('SHOT_ROOT')) exit;

abstract class SessionModel
	extends RedBean_SimpleModel
{
	public function dispense()
	{
		$this->bean->time = time();
		$this->bean->setMeta('data.store', array());
	}

	public function open()
	{
		$this->bean->time = time();
		$this->bean->setMeta('data.store', JSON::decode($this->bean->data));
	}

	public function update()
	{
		$this->bean->time = time();
		$this->bean->data = JSON::encode($this->bean->getMeta('data.store'));
	}

}

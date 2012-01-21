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

/**
 * Shot - Model base
 * 	     Provides base methods for models to leverage.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
abstract class ModelBase
{
	protected $id, $data, $pending;

	public function getID()
	{
		return $this->id;
	}

	public function setID($name)
	{
		$this->id = $name;	

		return $this;
	}

	public function get($field, $default = NULL)
	{
		if(isset($this->pending[(string) $field]))
		{
			return $this->pending[(string) $field];
		}
		elseif(isset($this->data[(string) $field]))
		{
			return $this->data[(string) $field];
		}
		else
		{
			return $default;
		}
	}

	public function isset($field)
	{
		return (isset($this->pending[(string) $field]) || isset($this->data[(string) $field])) ? true : false;
	}

	public function set($field, $value)
	{
		$this->pending[(string) $field] = $value;

		return $this;
	}

	public function isClean()
	{
		return (!empty($this->pending)) ? true : false;
	}

	abstract public function load();

	abstract public function save();

	abstract public function delete();

	public function __get($field)
	{
		return $this->get($field, NULL);
	}

	public function __isset($field)
	{
		return $this->isset($field);
	}

	public function __set($field, $value)
	{
		return $this->set($field, $value);
	}
}

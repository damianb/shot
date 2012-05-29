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

namespace emberlabs\shot\RedBean;

if(!defined('SHOT_ROOT')) exit;

class ModelFormatter
	implements \RedBean_IModelFormatter
{
	/**
	 * Get the properly formatted (php 5.3 namespaced name, in our case) class name for the model we want to use
	 * @param string $model - The name of the model we're looking for
	 * @param mixed $bean - Unknown
	 * @return string - The full namespaced string for the model we're looking to load
	 */
	public function formatModel($model, $bean = NULL)
	{
		return APP_NAMESPACE . '\\Model\\' . ucfirst($model) . 'Model';
    }
}

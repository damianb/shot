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

namespace emberlabs\shot\Request;
use \emberlabs\shot\WebKernel;
use \emberlabs\shot\Model\ModelBase;

/**
 * Shot - Authenticated request object
 * 	     Handles and provides request data for authenticated (non-guest) users to controllers.
 *
 * @package     shot
 * @author      emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 * @link        https://github.com/emberlabs/shot/
 */
class Authenticated
	extends Standard
{
	public $user, $group;

	protected $user_id, $group_id;

	public function __construct(ModelBase $user, ModelBase $group = NULL)
	{
		parent::__construct();

		if($group !== NULL)
		{
			$this->group = $group;
			$this->group_id = $group->getID();
		}

		$this->user = $user;
		$this->user_id = $user->getID();
	}

	public function getUserID()
	{
		return $this->user_id;
	}

	public function getGroupID()
	{
		return $this->group_id;
	}

	public function auth($auth)
	{
		$kernel = WebKernel::getInstance();
		return $kernel->acl->check($this->group_id, $auth);
	}

	public function isAuthenticated()
	{
		return true;
	}
}

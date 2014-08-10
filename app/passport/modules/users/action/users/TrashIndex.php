<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\users\action\users;

use library\actions;
use tfc\ap\Ap;

/**
 * TrashIndex class file
 * 查询回收站数据列表
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TrashIndex.php 1 2014-08-08 15:49:14Z Code Generator $
 * @package modules.users.action.users
 * @since 1.0
 */
class TrashIndex extends actions\Index
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		Ap::getRequest()->setParam('trash', 'y');
		$this->execute('Users');
	}
}

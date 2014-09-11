<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\site;

use library;
use modules\system\model\Account;

/**
 * Logout class file
 * 注销账户
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Logout.php 1 2014-08-08 15:49:14Z huan.song $
 * @package modules.users.action.account
 * @since 1.0
 */
class Logout extends library\ShowAction
{
	/**
	 * @var boolean 是否验证登录
	 */
	protected $_validLogin = false;

	/**
	 * @var boolean 是否验证身份授权
	 */
	protected $_validAuth = false;

	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$mod = new Account();
		$mod->logout();
		$this->forward('login');
	}
}

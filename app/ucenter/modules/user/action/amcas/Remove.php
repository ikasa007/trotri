<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\user\action\amcas;

use library\actions;

/**
 * Remove class file
 * 删除数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Remove.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class Remove extends actions\Remove
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		exit('modules\\system\\action\\site\\Remove');
	}
}
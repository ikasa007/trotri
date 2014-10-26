<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\advert\action\adverts;

use library\actions;

/**
 * SingleModify class file
 * 编辑单个字段
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SingleModify.php 1 2014-10-26 19:08:03Z Code Generator $
 * @package modules.advert.action.adverts
 * @since 1.0
 */
class SingleModify extends actions\SingleModify
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$this->execute('Adverts');
	}
}

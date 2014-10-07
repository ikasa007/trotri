<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\action\posts;

use library\actions;

/**
 * Trash class file
 * 移至回收站和从回收站还原
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Trash.php 1 2014-09-16 19:32:26Z Code Generator $
 * @package modules.posts.action.posts
 * @since 1.0
 */
class Trash extends actions\Trash
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$this->execute('Posts');
	}
}
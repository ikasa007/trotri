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
use libapp\Model;
use tfc\ap\Ap;

/**
 * Modify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modify.php 1 2014-10-18 13:56:27Z Code Generator $
 * @package modules.posts.action.posts
 * @since 1.0
 */
class Modify extends actions\Modify
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$fields = array();

		$id = $this->getPk();
		if ($id > 0) {
			$fields = Model::getInstance('Posts')->getModuleFieldsByPostId($id);
		}

		if (Ap::getRequest()->getParam('do') === 'post') {
			// $data = Ap::getRequest()->getPost();
			// \tfc\saf\debug_dump($data);
		}

		$this->assign('profile_fields', array_keys($fields));
		$this->execute('Posts');
	}
}

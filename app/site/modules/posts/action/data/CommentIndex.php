<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\action\data;

use library\DataAction;
use tfc\ap\Ap;
use libapp\Model;
use library\PageHelper;

/**
 * CommentIndex class file
 * 文档列表页面
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: CommentIndex.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.posts.action.show
 * @since 1.0
 */
class CommentIndex extends DataAction
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();

		$postId = $req->getInteger('postid');
		$order = $req->getTrim('order', 'dt_last_modified DESC');
		$paged = PageHelper::getCurrPage();

		$mod = Model::getInstance('Comments', 'posts');
		$ret = $mod->getRowsByPostId($postId, $order, $paged);

		$this->display($ret);
	}
}

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
use tfc\ap\Ap;
use modules\user\service\Amcas AS SrvAmcas;
use modules\user\elements\Amcas AS EleAmcas;

/**
 * View class file
 * 查询数据详情
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: View.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.user.action.amcas
 * @since 1.0
 */
class View extends actions\Show
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$req = Ap::getRequest();
		$srv = new SrvAmcas();
		$ele = new EleAmcas($srv);

		$id = $req->getInteger('id');

		$ret = $srv->findByAmcaId($id);

		$this->assign('elements', $ele);
		$this->render($ret);
	}
}

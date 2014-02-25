<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\controller;

use library\BaseController;

/**
 * SiteController class file
 * 系统管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SiteController.php 1 2014-01-06 16:47:52Z huan.song $
 * @package modules.system.controller
 * @since 1.0
 */
class SiteController extends BaseController
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc.Controller::actions()
	 */
	public function actions()
	{
		return array(
			'index'        => 'modules\\system\\action\\show\\SiteIndex',
			'about'        => 'modules\\system\\action\\show\\SiteAbout',
			'err404'       => 'modules\\system\\action\\show\\SiteErr404',
		);
	}
}

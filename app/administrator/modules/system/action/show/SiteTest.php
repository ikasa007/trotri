<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\system\action\show;

use library\BaseAction;
use tfc\saf\Keys;

/**
 * SiteTest class file
 * 系统管理-Test
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: SiteTest.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.system.action.show
 * @since 1.0
 */
class SiteTest extends BaseAction
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$keys = new Keys('authentication');

		//$crypt = $keys->getCrypt();
		//var_dump($crypt);

		$config = $keys->getConfig();
		var_dump($config);

		//$sign = $keys->getSign();
		//var_dump($sign);
/*
		$expiry = $keys->getExpiry();
		var_dump($expiry);

		$rndLen = $keys->getRndLen();
		var_dump($expiry);
		*/
	}
}

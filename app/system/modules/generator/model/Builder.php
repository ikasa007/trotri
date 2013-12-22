<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;

/**
 * Builder class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Builder
{
	/**
	 * 生成代码
	 * @param integer $generatorId
	 */
	public function create($generatorId)
	{
		$generatorId = (int) $generatorId;
		
		var_dump($generatorId);
	}
}
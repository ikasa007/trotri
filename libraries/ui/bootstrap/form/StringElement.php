<?php
/**
 * Trotri Ui Bootstrap
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\form;

/**
 * StringElement class file
 * 按钮类表单元素
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: StringElement.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.form
 * @since 1.0
 */
class StringElement extends InputElement
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\form.InputElement::getInput()
	 */
	public function getInput()
	{
		return $this->value;
	}
}

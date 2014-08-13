<?php
/**
 * Trotri Foundation Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace tfc\validator;

/**
 * NotEmptyValidator class file
 * 验证一个值是否不为空
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: NotEmptyValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.validator
 * @since 1.0
 */
class NotEmptyValidator extends Validator
{
    /**
     * @var string 默认出错后的提醒消息
     */
    protected $_message = 'is empty.';

    /**
     * (non-PHPdoc)
     * @see \tfc\validator\Validator::isValid()
     */
    public function isValid()
    {
        $value = $this->getValue();
        return ((!empty($value)) == $this->getOption());
    }
}

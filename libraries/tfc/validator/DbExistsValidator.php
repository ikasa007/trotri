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

use tfc\ap\ErrorException;
use tfc\saf\DbProxy;

/**
 * DbExistsValidator class file
 * 验证值是否在数据库表中是否存在
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DbExistsValidator.php 1 2013-03-29 16:48:06Z huan.song $
 * @package tfc.validator
 * @since 1.0
 */
class DbExistsValidator extends Validator
{
    /**
     * @var instance of tfc\saf\DbProxy
     */
    protected $_dbProxy = null;

    /**
     * @var string 表名
     */
    protected $_tableName;

    /**
     * @var string 字段名
     */
    protected $_columnName;

    /**
     * @var string 默认出错后的提醒消息
     */
    protected $_message = 'A record matching the input was found.';

    /**
     * 构造方法：初始化需要验证的值、验证参考内容、出错后返回的消息、数据库操作类、表名、字段名
     * @param mixed $value
     * @param mixed $option
     * @param string $message
     * @param tfc\saf\DbProxy $dbProxy
     * @param string $tableName
     * @param string $columnName
     */
    public function __construct($value, $option, $message = '', DbProxy $dbProxy, $tableName, $columnName)
    {
        parent::__construct($value, $option, $message);

        $this->_dbProxy = $dbProxy;
        $this->_tableName = $this->_dbProxy->getTblprefix() . $tableName;
        $this->_columnName = $columnName;
    }

    /**
     * (non-PHPdoc)
     * @see tfc\validator.Validator::isValid()
     */
    public function isValid()
    {
        if ($this->_dbProxy === null) {
            throw new ErrorException('DbExistsValidator No database Proxy present.');
        }

        $sql = 'SELECT COUNT(*) FROM ' . $this->_tableName . ' WHERE ' . $this->_columnName . ' = ?';
        $total = $this->_dbProxy->fetchColumn($sql, $this->getValue());
        if ($total === false) {
            throw new ErrorException('DbExistsValidator database Proxy Exec Sql Failed.');
        }

        return (($total > 0) == $this->getOption());
    }
}

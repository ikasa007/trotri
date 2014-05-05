<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\library;

use tfc\ap\ErrorException;

/**
 * FormProcessor abstract class file
 * 表单数据处理基类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FormProcessor.php 1 2013-03-29 16:48:06Z huan.song $
 * @package srv.library
 * @since 1.0
 */
abstract class FormProcessor
{
	/**
	 * @var string 操作类型：新增记录
	 */
	const OP_TYPE_INSERT = 'INSERT';

	/**
	 * @var string 操作类型：编辑记录
	 */
	const OP_TYPE_UPDATE = 'UPDATE';

	/**
	 * @var string 操作类型：新增记录或编辑记录
	 */
	protected $_opType = '';

	/**
	 * @var srv\library\Model 寄存业务层的model类实例
	 */
	protected $_object = null;

	/**
	 * @var array 寄存所有错误信息
	 */
	protected $_errors = array();

	/**
	 * @var array 寄存所有表单元素的值
	 */
	protected $_values = array();

	/**
	 * 构造方法：初始化操作类型
	 * @param srv\library\Model $object
	 * @param string $opType 'INSERT' or 'UPDATE'
	 * @throws ErrorException 如果指定的操作类型不是INSERT或UPDATE，抛出异常
	 */
	public function __construct(Model $object, $opType)
	{
		$this->_object = $object;

		if (!defined('static::OP_TYPE_' . $opType)) {
            throw new ErrorException(sprintf(
                'FormProcessor op type "%s" must be INSERT or UPDATE', $opType
            ));
        }

        $this->_opType = $opType;
	}

	/**
	 * 处理表单数据
	 * @param array $params
	 * @param integer $id
	 * @return boolean
	 */
	public abstract function process(array $params = array(), $id = 0);

	/**
	 * 基于配置清理表单提交的数据
	 * <pre>
	 * 一.清理规则：
	 * $rules = array(
	 *	 'user_loginname' => 'trim',
	 *	 'user_interest' => array($foo, 'explode')
	 * );
	 * 参数：
	 * $attributes = array(
	 *	 'user_loginname' => '  abcdefghi  ',
	 *	 'user_interest' => ' 1, 2'
	 * );
	 * 结果：
	 * $result = array(
	 *	 'user_loginname' => 'abcdefghi',
	 *	 'user_interest' => array(1, 2)
	 * );
	 *
	 * 二.清理规则：
	 * $rules = array(
	 *	 'user_password' => 'md5',
	 *	 'user_interest' => array($foo, 'implode')
	 * );
	 * 参数：
	 * $attributes = array(
	 *	 'user_password' => '  1234  ',
	 *	 'user_interest' => array(1, 2)
	 * );
	 * 结果：
	 * $result = array(
	 *	 'user_loginname' => '81dc9bdb52d04dc20036dbd8313ed055',
	 *	 'user_interest' => '1,2'
	 * );
	 * </pre>
	 * @param array $rules
	 * @param array $attributes
	 * @return array
	 */
	public function clean(array $rules, array $attributes)
	{
		if ($rules === null || $attributes === null) {
			return ;
		}

		foreach ($rules as $columnName => $funcName) {
			if (isset($attributes[$columnName])) {
				$attributes[$columnName] = call_user_func($funcName, $attributes[$columnName]);
			}
		}

		return $attributes;
	}

	/**
	 * 获取所有的错误信息
	 * @param boolean $justOne
	 * @return array
	 */
	public function getErrors($justOne = false)
	{
		if (!$justOne) {
			return $this->_errors;
		}

		$errors = array();
		foreach ($this->_errors as $key => $value) {
			$errors[$key] = is_array($value) ? array_shift($value) : $value;
		}

		return $errors;
	}

	/**
	 * 清除所有的错误信息
	 * @return srv\library\FormProcessor
	 */
	public function clearErrors()
	{
		$this->_errors = array();
		return $this;
	}

	/**
	 * 通过键名获取错误信息
	 * @param string|null $key
	 * @param boolean $justOne
	 * @return mixed
	 */
	public function getError($key = null, $justOne = true)
	{
		if (empty($this->_errors)) {
			return null;
		}

		if ($key === null) {
			return array_shift(array_slice($this->_errors, 0, 1));
		}
		elseif (isset($this->_errors[$key])) {
			return ($justOne && is_array($this->_errors[$key])) ? array_shift($this->_errors[$key]) : $this->_errors[$key];
		}
		else {
			return null;
		}
	}

	/**
	 * 添加一条错误信息
	 * @param string $key
	 * @param string $value
	 * @return srv\library\FormProcessor
	 */
	public function addError($key, $value)
	{
		if (isset($this->_errors[$key])) {
			if (!is_array($this->_errors[$key])) {
				$this->_errors[$key] = array($this->_errors[$key]);
			}

			$this->_errors[$key][] = $value;
		}
		else {
			$this->_errors[$key] = $value;
		}

		return $this;
	}

	/**
	 * 通过键名判断错误信息是否存在
	 * @param string|null $key
	 * @return boolean
	 */
	public function hasError($key = null)
	{
		if ($key === null) {
			return (count($this->_errors) > 0);
		}

		return isset($this->_errors[$key]);
	}

	/**
	 * 获取所有的表单元素
	 * @return array
	 */
	public function getValues()
	{
		return $this->_values;
	}

	/**
	 * 魔术方法：请求get开头的方法，获取一个表单元素的值
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return isset($this->_values[$name]) ? $this->_values[$name] : null;
	}

	/**
	 * 魔术方法：请求set开头的方法，设置一个表单元素的值
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		$this->_values[$name] = $value;
	}

	/**
	 * 验证是否是“新增记录”操作类型
	 * @return boolean
	 */
	public function isInsert()
	{
		return $this->_opType === self::OP_TYPE_INSERT;
	}

	/**
	 * 验证是否是“编辑记录”操作类型
	 * @return boolean
	 */
	public function isUpdate()
	{
		return $this->_opType === self::OP_TYPE_UPDATE;
	}

}
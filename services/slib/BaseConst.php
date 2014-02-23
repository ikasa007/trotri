<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright (c) 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace slib;

/**
 * BaseConst abstract class file
 * 业务层：数据寄存器基类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BaseConst.php 1 2013-03-29 16:48:06Z huan.song $
 * @package slib
 * @since 1.0
 */
abstract class BaseConst
{
	/**
	 * @var instance of slib\Language
	 */
	protected $_language = null;

	/**
	 * @var array instances of slib\BaseConst
	 */
	protected static $_instances = array();

	/**
	 * 构造方法：初始化语言国际化管理类
	 * @param slib\Language $language
	 */
	protected function __construct(Language $language)
	{
		$this->_language = $language;
	}

	/**
	 * 魔术方法：禁止被克隆
	 */
	private function __clone()
	{
	}

	/**
	 * 单例模式：获取本类的实例
	 * @param slib\Language $language
	 * @return instance of slib\BaseConst
	 */
	public static function getInstance(Language $language)
	{
		$type = $language->getType();
		if (!isset(self::$_instances[$type])) {
			self::$_instances[$type] = new self($language);
		}

		return self::$_instances[$type];
	}

	/**
	 * 获取所有本类的实例化对象
	 * @return instances of slib\BaseConst
	 */
	public static function getInstances()
	{
		return self::$_instances;
	}

	/**
	 * 通过多个字段名，获取这些字段选项
	 * @param array $columnNames
	 * @return array
	 */
	public function getEnums($columnNames)
	{
		$ret = array();

		$columnNames = (array) $columnNames;
		foreach ($columnNames as $columnName) {
			$ret[$columnName] = $this->getEnum($columnName);
		}

		return $ret;
	}

	/**
	 * 通过字段名，获取该字段选项
	 * @param string $columnName
	 * @return array
	 */
	public function getEnum($columnName)
	{
		$method = 'get' . str_replace('_', '', $columnName) . 'Enum';
		if (method_exists($this, $method)) {
			return $this->$method();
		}

		return array();
	}

	/**
	 * 通过多个字段名，获取这些字段验证规则
	 * @param array $columnNames
	 * @return array
	 */
	public function getRules($columnNames)
	{
		$ret = array();

		$columnNames = (array) $columnNames;
		foreach ($columnNames as $columnName) {
			$ret[$columnName] = $this->getRule($columnName);
		}

		return $ret;
	}

	/**
	 * 通过字段名，获取该字段验证规则
	 * @param string $columnName
	 * @return array
	 */
	public function getRule($columnName)
	{
		$method = 'get' . str_replace('_', '', $columnName) . 'Rule';
		if (method_exists($this, $method)) {
			return $this->$method();
		}

		return array();
	}

	/**
	 * 获取语言国际化管理类
	 * @return instance of slib\Language
	 */
	public function getLanguage()
	{
		return $this->_language;
	}

	/**
	 * 通过键名获取语言内容
	 * @param string $string
	 * @param boolean $jsSafe
	 * @param boolean $interpretBackSlashes
	 * @return string
	 */
	public function _($string, $jsSafe = false, $interpretBackSlashes = true)
	{
		return $this->getLanguage()->_($string, $jsSafe, $interpretBackSlashes);
	}
}

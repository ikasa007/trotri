<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use slib\BaseModel;
use slib\Db;
use slib\Data;
use slib\ErrorNo;

/**
 * ModBuilders class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModBuilders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class ModBuilders extends BaseModel
{
	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rules = array(
			'trash' => 'trim',
			'builder_name' => 'trim',
			'builder_id' => 'intval',
			'tbl_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'app_name' => 'trim'
		);

		$this->_filterCleanEmpty($params, $rules);
		$ret = $this->findAllByAttributes($params, $order, $limit, $offset);
		return $ret;
	}

	/**
	 * 通过builder_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByBuilderId($value)
	{
		$value = (int) $value;
		$ret = $this->getByPk('builder_name', $value);
		$builderName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['builder_name'];
		return $builderName;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		$params['dt_created'] = date('Y-m-d H:i:s');
		if (!isset($params['index_row_btns']) || !is_array($params['index_row_btns'])) {
			$params['index_row_btns'] = array();
		}

		return $this->autoInsert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		unset($params['trash']);
		$params['dt_modified'] = date('Y-m-d H:i:s');
		return $this->autoUpdateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		$data = Data::getInstance('builders', 'builder', $this->getLanguage());
		$rules = $data->getRules(array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'act_index_name',
			'act_view_name',
			'act_create_name',
			'act_modify_name',
			'act_remove_name',
			'index_row_btns',
			'trash',
		));

		return $this->filterRun($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPreValidator()
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'builder_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_comment' => array($this, 'cleanXss'),
			'app_name' => 'trim',
			'mod_name' => 'trim',
			'ctrl_name' => 'trim',
			'cls_name' => 'trim',
			'description' => array($this, 'cleanXss'),
			'act_index_name' => 'trim',
			'act_view_name' => 'trim',
			'act_create_name' => 'trim',
			'act_modify_name' => 'trim',
			'act_remove_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'trash' => 'trim',
			'index_row_btns' => array($this, 'trims')
		);

		$ret = $this->_clean($rules, $attributes);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPostValidator()
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'index_row_btns' => array($this, 'join')
		);

		$ret = $this->_clean($rules, $attributes);
		return $ret;
	}
}
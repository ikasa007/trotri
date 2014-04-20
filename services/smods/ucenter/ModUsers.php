<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\ucenter;

use tfc\ap\Ap;
use tfc\util\Language;
use tfc\util\String;
use tfc\saf\Log;
use slib\BaseModel;
use slib\Data;
use slib\Model;
use slib\ErrorNo;
use smods\ucenter\validator\UsersLoginName;
use smods\ucenter\validator\UsersLoginNameUnique;

/**
 * ModUsers class file
 * 业务层：模型类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ModUsers.php 1 2014-04-15 14:43:50Z Code Generator $
 * @package smods.ucenter
 * @since 1.0
 */
class ModUsers extends BaseModel
{
	/**
	 * 构造方法：初始化数据库操作类和语言国际化管理类
	 * @param tfc\util\Language $language
	 * @param integer $tableNum 分表数字，如果 >= 0 表示分表操作
	 */
	public function __construct(Language $language, $tableNum = -1)
	{
		$db = new DbUsers($tableNum);
		parent::__construct($db, $language);
	}

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
			'login_name' => 'trim',
			'login_type' => 'trim',
			'user_name' => 'trim',
			'user_mail' => 'trim',
			'user_phone' => 'trim',
			'valid_mail' => 'trim',
			'valid_phone' => 'trim',
			'forbidden' => 'trim',
			'trash' => 'trim',
		);

		$data = Data::getInstance('Users', 'ucenter', $this->getLanguage());
		$params['group_id'] = isset($params['group_ids']) ? (int) $params['group_ids'] : 0;
		$params['trash'] = $data::TRASH_N;

		$this->_filterCleanEmpty($params, $rules);

		$data = $this->getDb()->search($params, $order, $limit, $offset);
		if ($data === false) {
			$errNo = ErrorNo::ERROR_DB_SELECT;
			$errMsg = $this->_('ERROR_MSG_ERROR_DB_SELECT');
			Log::warning(sprintf(
				'%s attributes "%s", order "%s", limit "%d", offset "%d"',
				$errMsg, serialize($params), $order, $limit, $offset
			), $errNo, __METHOD__);
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		$errNo = ErrorNo::SUCCESS_NUM;
		$errMsg = $this->_('ERROR_MSG_SUCCESS_SELECT');
		Log::debug(sprintf(
			'%s attributes "%s", order "%s", limit "%d", offset "%d"',
			$errMsg, serialize($params), $order, $limit, $offset
		), __METHOD__);

		$ret = array(
			'err_no' => $errNo,
			'err_msg' => $errMsg,
			'data' => $data,
			'paginator' => array(
				'attributes' => $params,
				'order' => $order,
				'limit' => $limit,
				'offset' => $offset
			)
		);

		return $this->_applyFoundRows($ret, self::QU_OPT_CALC_FOUND_ROWS);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = Model::getInstance('UserGroups', 'ucenter', $this->getLanguage())->findGroupIdsByUserId($value);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$groupIds = $ret['data'];
		$ret = parent::findByPk($value);
		if ($ret['err_no'] === ErrorNo::SUCCESS_NUM) {
			unset($ret['data']['password']);
			$ret['data']['group_ids'] = $groupIds;
		}

		return $ret;
	}

	/**
	 * 通过登录名，查询一条记录。
	 * @param string $value
	 * @return array
	 */
	public function findByLoginName($value)
	{
		return parent::findByAttributes(array('login_name' => trim($value)));
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
	{
		if (isset($params['trash'])) { unset($params['trash']); }

		$params['dt_registered'] = $params['dt_last_login'] = date('Y-m-d H:i:s');
		$params['ip_registered'] = $params['ip_last_login'] = ip2long(Ap::getRequest()->getClientIp());
		$params['login_count'] = 1;
		$params['repwd_count'] = 0;
		$params['salt'] = $this->getSalt();

		$loginName = isset($params['login_name']) ? trim($params['login_name']) : '';
		$params['login_type'] = $loginType = $this->getLoginType($loginName);

		if ($this->isMailLogin($loginType)) {
			if (!isset($params['user_mail']) || trim($params['user_mail']) === '') {
				$params['user_mail'] = $loginName;
			}
		}
		elseif ($this->isPhoneLogin($loginType)) {
			if (!isset($params['user_phone']) || trim($params['user_phone']) === '') {
				$params['user_phone'] = $loginName;
			}
		}
		else {
			if (!isset($params['user_name']) || trim($params['user_name']) === '') {
				$params['user_name'] = $loginName;
			}
		}

		$repassword = isset($params['repassword']) ? trim($params['repassword']) : '';
		$groupIds = isset($params['group_ids']) ? (array) $params['group_ids'] : array();

		$opType = self::OP_TYPE_INSERT;

		UsersLoginName::$object = $this;
		UsersLoginName::$opType = $opType;
		UsersLoginNameUnique::$object = $this;
		UsersLoginNameUnique::$opType = $opType;

		$this->_filterAttributes($params);
		$params['repassword'] = $repassword;
		$params['group_ids'] = $groupIds;

		$attributes = $this->_cleanPreValidator($params, $opType);
		$ret = $this->validatePreInsert($attributes, true);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		unset($attributes['repassword'], $attributes['group_ids']);
		$attributes['password'] = $this->encrypt($attributes['password'], $attributes['salt']);

		$attributes = $this->_cleanPostValidator($attributes, $opType);
		$ret = $this->insert($attributes, true);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$userId = $ret['id'];
		$ret = Model::getInstance('UserGroups', 'ucenter', $this->getLanguage())->modify($userId, $groupIds);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$ret['id'] = $userId;
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		if (isset($params['trash'])) { unset($params['trash']); }
		if (isset($params['login_name'])) { unset($params['login_name']); }
		if (isset($params['login_type'])) { unset($params['login_type']); }
		if (isset($params['salt'])) { unset($params['salt']); }

		$password = isset($params['password']) ? trim($params['password']) : '';
		if ($password !== '') {
			$params['salt'] = $this->getSalt();

			$params['dt_last_repwd'] = date('Y-m-d H:i:s');
			$params['ip_last_repwd'] = ip2long(Ap::getRequest()->getClientIp());

			$params['repwd_count'] = (int) $this->getColById('repwd_count', $value) + 1;

			$repassword = isset($params['repassword']) ? trim($params['repassword']) : '';
		}
		else {
			unset($params['password']);
		}

		$groupIds = isset($params['group_ids']) ? (array) $params['group_ids'] : array();

		$opType = self::OP_TYPE_UPDATE;

		UsersLoginName::$object = $this;
		UsersLoginName::$opType = $opType;
		UsersLoginNameUnique::$object = $this;
		UsersLoginNameUnique::$opType = $opType;
		UsersLoginNameUnique::$id = $value;

		$this->_filterAttributes($params);
		if ($password !== '') {
			$params['repassword'] = $repassword;
		}

		$params['group_ids'] = $groupIds;

		$attributes = $this->_cleanPreValidator($params, $opType);

		$ret = $this->validatePreUpdate($attributes, false);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		if ($password !== '') {
			unset($attributes['repassword']);
			$attributes['password'] = $this->encrypt($attributes['password'], $attributes['salt']);
		}

		unset($attributes['group_ids']);

		$attributes = $this->_cleanPostValidator($attributes, $opType);
		$ret = $this->updateByPk($value, $attributes);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$userId = $ret['id'];
		$ret = Model::getInstance('UserGroups', 'ucenter', $this->getLanguage())->modify($userId, $groupIds);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return $ret;
		}

		$ret['id'] = $userId;
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::validate()
	 */
	public function validate(array $attributes = array(), $required = false, $opType = '')
	{
		$data = Data::getInstance($this->_className, $this->_moduleName, $this->getLanguage());
		$rules = $data->getRules(array(
			'login_name',
			'password',
			'repassword',
			'user_name',
			'user_mail',
			'user_phone',
			'forbidden',
			'group_ids',
		));

		if (!isset($attributes['user_name']) || $attributes['user_name'] === '') {
			unset($rules['user_name']);
		}

		if (!isset($attributes['user_mail']) || $attributes['user_mail'] === '') {
			unset($rules['user_mail']);
		}

		if (!isset($attributes['user_phone']) || $attributes['user_phone'] === '') {
			unset($rules['user_phone']);
		}

		return $this->filterRun($rules, $attributes, $required);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPreValidator()
	 */
	protected function _cleanPreValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
			'login_name' => 'trim',
			'password' => 'trim',
			'repassword' => 'trim',
			'user_name' => 'trim',
			'user_mail' => 'trim',
			'user_phone' => 'trim',
		);

		return $this->_clean($rules, $attributes);
	}

	/**
	 * (non-PHPdoc)
	 * @see slib.BaseModel::_cleanPostValidator()
	 */
	protected function _cleanPostValidator(array $attributes = array(), $opType = '')
	{
		$rules = array(
		);

		return $this->_clean($rules, $attributes);
	}

	/**
	 * 获取会员登录随机附加混淆码
	 * @return string
	 */
	public function getSalt()
	{
		return String::randStr(6);
	}

	/**
	 * 加密会员登录密码
	 * @param string $pwd
	 * @param string $salt
	 * @return string
	 */
	public function encrypt($pwd, $salt = '')
	{
		return md5($salt . substr(md5($pwd), 3));
	}

	/**
	 * 通过登录名自动识别登录方式
	 * @param string $loginName
	 * @return string
	 */
	public function getLoginType($loginName)
	{
		$data = Data::getInstance('Users', 'ucenter', $this->getLanguage());
		if (strpos($loginName, '@')) {
			return $data::LOGIN_TYPE_MAIL;
		}

		if (is_numeric($loginName)) {
			return $data::LOGIN_TYPE_PHONE;
		}

		return $data::LOGIN_TYPE_NAME;
	}

	/**
	 * 是否通过邮箱登录
	 * @param string $loginType
	 * @return boolean
	 */
	public function isMailLogin($loginType)
	{
		$data = Data::getInstance('Users', 'ucenter', $this->getLanguage());
		return $loginType === $data::LOGIN_TYPE_MAIL;
	}

	/**
	 * 是否通过手机号登录
	 * @param string $loginType
	 * @return boolean
	 */
	public function isPhoneLogin($loginType)
	{
		$data = Data::getInstance('Users', 'ucenter', $this->getLanguage());
		return $loginType === $data::LOGIN_TYPE_PHONE;
	}

	/**
	 * 用户登录
	 * @param string $loginName
	 * @param string $password
	 * @return array
	 */
	public function login($loginName, $password)
	{
		$data = Data::getInstance('Users', 'ucenter', $this->getLanguage());

		if (($loginName = trim($loginName)) === '') {
			$errNo = $data::ERROR_LOGIN_NAME_EMPTY;
			$errMsg = $this->_('MOD_UCENTER_USERS_LOGIN_NAME_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg
			);
		}

		if (($password = trim($password)) === '') {
			$errNo = $data::ERROR_LOGIN_PASSWORD_EMPTY;
			$errMsg = $this->_('MOD_UCENTER_USERS_LOGIN_PASSWORD_EMPTY');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		$ret = $this->findByLoginName($loginName);
		if ($ret['err_no'] === ErrorNo::ERROR_DB_SELECT_EMPTY) {
			$errNo = $data::ERROR_LOGIN_NAME_UNDEFINED;
			$errMsg = $this->_('MOD_UCENTER_USERS_LOGIN_NAME_UNDEFINED');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		$salt = $ret['data']['salt'];
		$password = $this->encrypt($password, $salt);
		if ($password !== $ret['data']['password']) {
			$errNo = $data::ERROR_LOGIN_PASSWORD_WRONG;
			$errMsg = $this->_('MOD_UCENTER_USERS_LOGIN_PASSWORD_WRONG');
			return array(
				'err_no' => $errNo,
				'err_msg' => $errMsg,
				'login_name' => $loginName
			);
		}

		$userId = (int) $ret['data']['user_id'];
		$loginName = $ret['data']['login_name'];
		return array(
			'err_no' => ErrorNo::SUCCESS_NUM,
			'err_msg' => '',
			'user_id' => $userId,
			'login_name' => $loginName
		);
	}
}
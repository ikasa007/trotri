<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use libsrv\FormProcessor;
use tfc\ap\Ap;
use tfc\validator;
use posts\library\Lang;
use users\services\Users;

/**
 * FpPosts class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpPosts.php 1 2014-09-16 19:26:44Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class FpPosts extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params,
				'title', 'little_picture', 'category_id', 'content', 'keywords', 'description', 'sort',
				'is_public', 'is_head', 'is_recommend', 'is_jump', 'jump_url', 'is_html', 'allow_comment', 'allow_other_modify',
				'access_count', 'dt_created', 'dt_public', 'dt_last_modified', 'creator_id', 'last_modifier_id')) {
				return false;
			}
		}

		$this->isValids($params,
			'title', 'little_picture', 'category_id', 'category_name', 'content', 'keywords', 'description', 'sort',
			'is_public', 'is_head', 'is_recommend', 'is_jump', 'jump_url', 'is_html', 'allow_comment', 'allow_other_modify',
			'access_count', 'dt_created', 'dt_public', 'dt_last_modified', 'creator_id', 'creator_name', 'last_modifier_id', 'last_modifier_name');
		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		if (isset($params['trash'])) { unset($params['trash']); }

		if ($this->isInsert()) {
			$params['ip_created'] = $params['ip_last_modified'] = ip2long(Ap::getRequest()->getClientIp());
		}
		else {
			$params['ip_last_modified'] = ip2long(Ap::getRequest()->getClientIp());
			if (isset($params['creator_id'])) { unset($params['creator_id']); }
			if (isset($params['ip_created'])) { unset($params['ip_created']); }
		}

		$params['allow_other_modify'] = DataPosts::ALLOW_OTHER_MODIFY_Y;

		$rules = array(
			'title' => 'trim',
			'little_picture' => 'trim',
			'category_id' => 'intval',
			'keywords' => 'trim',
			'sort' => 'intval',
			'is_public' => 'trim',
			'trash' => 'trim',
			'is_head' => 'trim',
			'is_recommend' => 'trim',
			'is_jump' => 'trim',
			'jump_url' => 'trim',
			'is_html' => 'trim',
			'allow_comment' => 'trim',
			'allow_other_modify' => 'trim',
			'access_count' => 'intval',
			'dt_created' => 'trim',
			'dt_public' => 'trim',
			'dt_last_modified' => 'trim',
			'creator_id' => 'intval',
			'last_modifier_id' => 'intval',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_cleanPostProcess()
	 */
	public function _cleanPostProcess()
	{
		$categories = new Categories();
		$users = new Users();

		if ($this->category_id > 0) {
			$this->category_name = $categories->getCategoryNameByCategoryId($this->category_id);
			if ($this->category_name === '') {
				$this->addError('category_name', Lang::_('SRV_FILTER_POSTS_CATEGORY_ID_EXISTS'));
			}
		}

		if ($this->creator_id > 0) {
			$this->creator_name = $users->getLoginNameByUserId($this->creator_id);
			if ($this->creator_name === '') {
				$this->addError('creator_name', Lang::_('SRV_FILTER_POSTS_CREATOR_ID_EXISTS'));
			}	
		}

		if ($this->last_modifier_id > 0) {
			$this->last_modifier_name = $users->getLoginNameByUserId($this->last_modifier_id);
			if ($this->last_modifier_name === '') {
				$this->addError('last_modifier_name', Lang::_('SRV_FILTER_POSTS_LAST_MODIFIER_ID_EXISTS'));
			}
		}

		return !$this->hasError();
	}

	/**
	 * 获取“文档标题”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTitleRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POSTS_TITLE_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POSTS_TITLE_MAXLENGTH')),
		);
	}

	/**
	 * 获取“所属类别”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getCategoryIdRule($value)
	{
		return array(
			'Integer' => new validator\IntegerValidator($value, true, Lang::_('SRV_FILTER_POSTS_CATEGORY_ID_INTEGER')),
		);
	}

	/**
	 * 获取“关键字”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getKeywordsRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POSTS_KEYWORDS_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POSTS_KEYWORDS_MAXLENGTH')),
		);
	}

	/**
	 * 获取“内容摘要”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getDescriptionRule($value)
	{
		return array(
			'MaxLength' => new validator\MaxLengthValidator($value, 240, Lang::_('SRV_FILTER_POSTS_DESCRIPTION_MAXLENGTH')),
		);
	}

	/**
	 * 获取“排序”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getSortRule($value)
	{
		return array(
			'Integer' => new validator\IntegerValidator($value, true, Lang::_('SRV_FILTER_POSTS_SORT_INTEGER')),
		);
	}

	/**
	 * 获取“是否发表”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsPublicRule($value)
	{
		$enum = DataPosts::getIsPublicEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_IS_PUBLIC_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“是否删除”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTrashRule($value)
	{
		$enum = DataPosts::getTrashEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_TRASH_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“是否头条”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsHeadRule($value)
	{
		$enum = DataPosts::getIsHeadEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_IS_HEAD_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“是否推荐”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsRecommendRule($value)
	{
		$enum = DataPosts::getIsRecommendEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_IS_RECOMMEND_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“是否跳转”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsJumpRule($value)
	{
		$enum = DataPosts::getIsJumpEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_IS_JUMP_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“跳转链接”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getJumpUrlRule($value)
	{
		if ($this->is_jump === DataPosts::IS_JUMP_N) {
			return array();
		}

		return array(
			'Url' => new validator\UrlValidator($value, true, Lang::_('SRV_FILTER_POSTS_JUMP_URL_URL')),
		);
	}

	/**
	 * 获取“生成静态页面”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsHtmlRule($value)
	{
		$enum = DataPosts::getIsHtmlEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_IS_HTML_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“是否允许评论”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAllowCommentRule($value)
	{
		$enum = DataPosts::getAllowCommentEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_ALLOW_COMMENT_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“允许其他人编辑”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAllowOtherModifyRule($value)
	{
		$enum = DataPosts::getAllowOtherModifyEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POSTS_ALLOW_OTHER_MODIFY_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“访问次数”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAccessCountRule($value)
	{
		return array(
			'NonNegativeInteger' => new validator\NonNegativeIntegerValidator($value, true, Lang::_('SRV_FILTER_POSTS_ACCESS_COUNT_NONNEGATIVEINTEGER')),
		);
	}

	/**
	 * 获取“创建时间”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getDtCreatedRule($value)
	{
		return array(
			'DateTime' => new validator\DateTimeValidator($value, true, Lang::_('SRV_FILTER_POSTS_DT_CREATED_DATETIME')),
		);
	}

	/**
	 * 获取“发布时间”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getDtPublicRule($value)
	{
		return array(
			'DateTime' => new validator\DateTimeValidator($value, true, Lang::_('SRV_FILTER_POSTS_DT_PUBLIC_DATETIME')),
		);
	}

	/**
	 * 获取“上次编辑时间”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getDtLastModifiedRule($value)
	{
		return array(
			'DateTime' => new validator\DateTimeValidator($value, true, Lang::_('SRV_FILTER_POSTS_DT_LAST_MODIFIED_DATETIME')),
		);
	}

	/**
	 * 获取“创建人”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getCreatorIdRule($value)
	{
		return array(
			'Integer' => new validator\IntegerValidator($value, true, Lang::_('SRV_FILTER_POSTS_CREATOR_ID_INTEGER')),
		);
	}

	/**
	 * 获取“上次编辑人”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getLastModifierIdRule($value)
	{
		return array(
			'Integer' => new validator\IntegerValidator($value, true, Lang::_('SRV_FILTER_POSTS_LAST_MODIFIER_ID_INTEGER')),
		);
	}

}
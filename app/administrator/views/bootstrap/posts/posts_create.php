<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elements_object' => $this->elements,
		'elements' => array(
			'category_id' => array(
				'options' => $this->elements->getCategoryNames()
			),
			'module_id' => array(
				'options' => $this->elements->getModuleNames()
			),
		),
		'columns' => array(
			'title',
			'alias',
			'category_id',
			'module_id',
			'picture',
			'picture_file',
			'content',
			'keywords',
			'description',
			'sort',
			'password',
			'is_head',
			'is_recommend',
			'is_jump',
			'jump_url',
			'is_public',
			'dt_public_up',
			'dt_public_down',
			'comment_status',
			'allow_other_modify',
			'hits',
			'praise_count',
			'comment_count',
			'creator_id',
			'creator_name',
			'last_modifier_id',
			'last_modifier_name',
			'dt_created',
			'dt_last_modified',
			'ip_created',
			'ip_last_modified',
			'_button_save_',
			'_button_saveclose_',
			'_button_savenew_',
			'_button_cancel_'
		)
	)
);
?>

<script type="text/javascript">
var g_fields = <?php echo $this->fields; ?>;
</script>
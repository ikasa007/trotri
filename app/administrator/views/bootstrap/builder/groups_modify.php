<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'tabs' => $this->tabs,
		'values' => $this->data,
		'errors' => $this->errors,
		'elements' => $this->elements,
		'columns' => array(
			'group_name',
			'prompt',
			'builder_name',
			'sort',
			'description',
			'builder_id',
			'_button_save_',
			'_button_save2close_',
			'_button_save2new_',
			'_button_cancel_'
		)
	)
);

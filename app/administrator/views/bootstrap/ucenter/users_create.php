<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'tabs' => $this->tabs,
		'errors' => $this->errors,
		'elements' => $this->elements,
		'columns' => array(
			'login_name',
			'password',
			'repassword',
			'user_name',
			'user_mail',
			'user_phone',
			'dt_registered',
			'dt_last_login',
			'dt_last_repwd',
			'ip_registered',
			'ip_last_login',
			'ip_last_repwd',
			'login_count',
			'repwd_count',
			'valid_mail',
			'valid_phone',
			'forbidden',
			'_button_save_',
			'_button_save2close_',
			'_button_save2new_',
			'_button_cancel_',
		)
	)
);

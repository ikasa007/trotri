<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'users_index' => array(
		'label' => 'MOD_USERS_URLS_USERS_INDEX',
		'm' => 'users', 'c' => 'users', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_USERS_URLS_USERS_CREATE',
			'm' => 'users', 'c' => 'users', 'a' => 'create'
		)
	),
	'users_trashindex' => array(
		'label' => 'MOD_USERS_URLS_USERS_TRASHINDEX',
		'm' => 'users', 'c' => 'users', 'a' => 'trashindex'
	),
	'groups' => array(
		'label' => 'MOD_USERS_URLS_GROUPS_INDEX',
		'm' => 'users', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_USERS_URLS_GROUPS_CREATE',
			'm' => 'users', 'c' => 'groups', 'a' => 'create'
		)
	),
	'amcas' => array(
		'label' => 'MOD_USERS_URLS_AMCAS_INDEX',
		'm' => 'users', 'c' => 'amcas', 'a' => 'index',
	)
);

if ($this->controller === 'users') {
	if ($this->action === 'trashindex') {
		$config['users_trashindex']['active'] = true;
	}
	else {
		$config['users_index']['active'] = true;
	}
}
elseif ($this->controller === 'groups') {
	$config['groups']['active'] = true;
}
elseif ($this->controller === 'amcas') {
	$config['amcas']['active'] = true;
}

$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));
?>

<?php
if ($this->controller === 'users') {
	$this->widget('views\bootstrap\widgets\SearchBuilder',
		array(
			'name' => 'create',
			'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'users', 'users'),
			'elements_object' => $this->elements,
			'elements' => array(
				'login_name' => array(
					'type' => 'text',
				),
				'user_id' => array(
					'type' => 'text',
				),
				'user_name' => array(
					'type' => 'text',
				),
				'user_mail' => array(
					'type' => 'text',
				),
				'user_phone' => array(
					'type' => 'text',
				),
				'group_id' => array(
					'options' => $this->elements->getGroupIds()
				),
				'forbidden' => array(
					'type' => 'select',
				),
				'login_type' => array(
					'type' => 'select',
				),
				'valid_mail' => array(
					'type' => 'select',
				),
				'valid_phone' => array(
					'type' => 'select',
				),
			),
			'columns' => array(
				'login_name',
				'user_id',
				'login_type',
				'user_name',
				'user_mail',
				'user_phone',
				'valid_mail',
				'valid_phone',
				'forbidden',
				'group_id',
			)
		)
	);
}
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/users.js?v=' . $this->version); ?>

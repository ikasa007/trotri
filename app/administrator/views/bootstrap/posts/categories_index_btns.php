<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_POSTS_URLS_CATEGORIES_CREATE,
		'jsfunc' => \views\bootstrap\components\ComponentsConstant::JSFUNC_HREF,
		'url' => $this->getUrlManager()->getUrl('create', '', ''),
		'glyphicon' => \views\bootstrap\components\ComponentsConstant::GLYPHICON_CREATE,
		'primary' => true,
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_MODIFY_SORT,
		'jsfunc' => 'Posts.batchModifySort',
		'url' => $this->getUrlManager()->getUrl('batchmodifysort', '', ''),
		'glyphicon' => 'pencil',
		'primary' => false,
	)
);
?>
</form>
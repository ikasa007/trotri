<?php $this->display('generator/fields_index_btns'); ?>

<?php
$elements = $this->elementCollections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'columns' => array(
			'field_name',
			'generator_id',
			'group_id',
			'type_id',
			'sort',
			'html_label',
			'column_auto_increment',
			'generator_field_validators' => array(
				'name' => 'generator_field_validators',
				'label' => $this->MOD_GENERATOR_GENERATOR_FIELD_VALIDATORS,
				'callback' => array($elements->uiComponents, 'getGeneratorFieldValidatorsLabel')
			),
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		),
		'data' => $this->data
	)
);
?>

<?php $this->display('generator/fields_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
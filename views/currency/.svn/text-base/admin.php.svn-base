<?php
/* @var $this CurrencyController */
/* @var $model Currency */

$this->breadcrumbs=array(
	'Currencies'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Currency', 'url'=>array('index')),
	array('label'=>'Create Currency', 'url'=>array('create')),
	array('label'=>'Update Latest Conversion Rate','url'=>array('updateconversionrate')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('currency-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Currencies</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'currency-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
        array(
            'id'=>'id',
            'class'=>'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
		'conversion_rate',
		'country',
		'currency',
        array(
            'name'=>'status',
            'header'=>'Status',
            'filter'=>array('1'=>'Active','0'=>'In active'),
            'value'=>'($data->status==1)?("Active"):("In active")',
        ),
		//'currency_code',
		//'status',
//		array(
//			'header'=>'Update Rate',
//			'type'=>'raw',
//			'value'=> 'CHtml::link($data->currency_code, Yii::app()->createUrl("currencymanager/currency/updateconversionrate",array("id"=>$data->id)))',
//		),
		/*
		'updated_time',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
<script>
    function reloadGrid(data) {
        $.fn.yiiGridView.update('currency-grid');
    }
</script>
<?php echo CHtml::ajaxSubmitButton('Activate',array('default/ajaxupdate','act'=>'doActive'), array('success'=>'reloadGrid')); ?>
<?php echo CHtml::ajaxSubmitButton('In Activate',array('default/ajaxupdate','act'=>'doInactive'), array('success'=>'reloadGrid')); ?>
<?php echo CHtml::ajaxSubmitButton('Update Conversion Rate',array('currency/updateconversionrate'), array('success'=>'reloadGrid')); ?>
<?php $this->endWidget(); ?>
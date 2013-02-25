<?php
/* @var $this CurrencyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Currencies',
);

$this->menu=array(
	array('label'=>'Create Currency', 'url'=>array('create')),
	array('label'=>'Manage Currency', 'url'=>array('admin')),
);
?>

<h1>Currencies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

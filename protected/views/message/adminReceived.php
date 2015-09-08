<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Message', 'url'=>array('index')),
	array('label'=>'Create Message', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('message-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Received Messages</h1>

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

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'message-grid',
	'dataProvider'=>$model->searchreceived(),
	'filter'=>$model,
	'columns'=>array(
        //array('name' => 'qt_supplierid',
        //    'header' => 'Supplier',
        //    'value' => '!empty($data->rel_supplier->sup_name)?$data->rel_supplier->sup_name:"N/A"',
        //    'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 'sup_name')), 'sup_id', 'sup_name'),), 
		'id',
		array('name' => 'user_id',
        //    'header' => 'Any thing',
            'value' => '!empty($data->user->username)?$data->user->username:"N/A"',
            'filter' => CHtml::listData(User::model()->findAll(array('order' => 'username')), 'id', 'username'),), 
		'content',
		'details',
		'created',
		'modified',
		array(
                         'class' => 'CButtonColumn',
                         'template' => '{view}',//{somecol}',
                         'htmlOptions' => array('style' => 'min-width:50px'),
                         'header' => 'Actions',
                    
                         'buttons' => array
                             (
                             'view' => array
                                 (
                                 'url' => 'Yii::app()->createUrl(\'message/read\', array(\'id\'=>$data->id))',
                                 )
                             //'somecol' => array
                                 //(
                                 //'label' => 'Create Purchase Order',
                                 //'imageUrl' => Yii::app()->request->baseUrl . '/images/purchase-orders_25x25.png',
                                 //'click'=>'function(){if(!confirm("This will create a copy of this good. Are you sure you want to do this?")) return false;}',
                                 //'url' => 'Yii::app()->createUrl(\'purchases/create\', array(\'quoteID\'=>$data->qt_id))',
                             //)
                         )                        
		),
	),
)); ?>

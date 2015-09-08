<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
    //array('label'=>'List User', 'url'=>array('index')),
    array('label' => 'Create User', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        //array('name' => 'qt_supplierid',
        //    'header' => 'Supplier',
        //    'value' => '!empty($data->rel_supplier->sup_name)?$data->rel_supplier->sup_name:"N/A"',
        //    'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 'sup_name')), 'sup_id', 'sup_name'),), 
        'id',
        array('name' => 'country_id',
            //    'header' => 'Any thing',
            'value' => '!empty($data->country->name)?$data->country->name:"N/A"',
            'filter' => CHtml::listData(Country::model()->findAll(array('order' => 'name')), 'id', 'name'),),
        'username',
        'email',
        array('name' => 'type',
            //    'header' => 'Any thing',
            'value' => '!empty($data->userType->name)?$data->userType->name:"N/A"',
            'filter' => CHtml::listData(UserType::model()->findAll(array('order' => 'name')), 'id', 'name'),),
        array(
            'name' => 'nofMessages',
            'filter' => '',
        ),
        array(
            'name' => 'numberOfComments',
            'filter' => '',            
        ),  
        array(
            'name' => 'nofMessagesRead',
            'filter' => '',            
        ),          
        array(
            'name' => 'messageDetails',
            'filter' => '',     
            'type' => 'raw',
        ),         
        
        /*
          'created',
          'modified',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}', //{somecol}',
            'htmlOptions' => array('style' => 'min-width:50px'),
            'header' => 'Actions',
            'buttons' => array
            (
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
));
?>

<?php
/* @var $this MessageController */
/* @var $model Message */

$this->breadcrumbs=array(
	'Messages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Message', 'url'=>array('index')),
	array('label'=>'Create Message', 'url'=>array('create')),
	//array('label'=>'View Message', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Message', 'url'=>array('admin')),
//        array('label'=>'View PDF', 'url'=>array('viewPDF', 'id'=>$model->id), 'linkOptions' => array('target' => '_blank')),
);
?>
<h1>Update Message: <?php echo $model->id; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span style="font-size: 15px; color: gray;">[Message ID: <?php echo $model->id; ?>]</span>
</h1>

<?php echo $this->renderPartial('_form', array(
          'model'=>$model,
'user_message' => $user_message,
)); ?>
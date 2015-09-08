<h3>Sent By:</h3>
<div><?php echo $model->user->username;?></div>
<br><br>

<h3>Message Content:</h3>
<div><?php echo $model->content;?></div>
<br><br>

<h3>Message Details:</h3>
<div><?php echo $model->content;?></div>
<br><br>


<h3>Comments:</h3>
<?php
foreach ($comments as $comment){
    ?>
<div style="font-weight: bold"><?= $comment->user->username ?></div>
<div><?= $comment->comment ?></div>
<br><br>
<?php
}
?>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

                    <div class="row">
               <?php echo $form->labelEx($newComment,'comment'); ?>
               <?php echo $form->textField($newComment,'comment',array('size'=>60,'maxlength'=>100)); ?>
               <?php echo $form->error($newComment,'comment'); ?>
          </div>
<?php echo CHtml::submitButton('Save', array('name' => 'save')); ?>
<?php $this->endWidget(); ?>
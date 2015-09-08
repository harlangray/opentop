<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">
     <?php Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker'); ?>     <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

     <p class="note">Fields with <span class="required">*</span> are required.</p>

     <?php echo $form->errorSummary($model); ?>

               <div class="row">
               <?php echo $form->labelEx($model,'country_id'); ?>
               <?php echo $form->dropDownList($model, 'country_id', CHtml::listData(
                          Country::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a Country')) ; ?>
               <?php echo $form->error($model,'country_id'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'username'); ?>
               <?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
               <?php echo $form->error($model,'username'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'email'); ?>
               <?php echo $form->textField($model,'email',array('size'=>30,'maxlength'=>30)); ?>
               <?php echo $form->error($model,'email'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'password'); ?>
               <?php echo $form->passwordField($model,'password',array('size'=>30,'maxlength'=>30)); ?>
               <?php echo $form->error($model,'password'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'type'); ?>
               <?php echo $form->dropDownList($model, 'type', CHtml::listData(
                          UserType::model()->findAll(), 'id', 'name'), array('prompt' => 'Select a UserType')) ; ?>
               <?php echo $form->error($model,'type'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'created'); ?>
               <?php echo $form->textField($model,'created'); ?>
               <?php echo $form->error($model,'created'); ?>
          </div>

                    <div class="row">
               <?php echo $form->labelEx($model,'modified'); ?>
               <?php $this->widget('CJuiDateTimePicker', array(
              'model' => $model, //Model object
              'attribute' => 'modified', //attribute name
              'mode' => 'datetime', //use 'time','date' or 'datetime' (default)
              'language' => '',
              'options' => array('dateFormat' => 'yy-mm-dd', 'timeFormat' => 'hh:mm:ss'), // jquery plugin options
              'htmlOptions' => array(
                  'style' => 'width:150px',
                  'class' => 'editableField'
              ),
          ));; ?>
               <?php echo $form->error($model,'modified'); ?>
          </div>

               <div class="row buttons">
          <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
     </div>

     <?php $this->endWidget(); ?>

</div><!-- form -->
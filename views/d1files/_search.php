<div class="wide form">

    <?php
    $form = $this->beginWidget('TbActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>
    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php ; ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'type'); ?>
        <?php echo CHtml::activeDropDownList($model, 'type', $model->getEnumFieldLabels('type')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'file_name'); ?>
        <?php echo $form->textField($model, 'file_name', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'upload_path'); ?>
        <?php echo $form->textArea($model, 'upload_path', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'add_datetime'); ?>
        <?php echo $form->textField($model, 'add_datetime'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'user_id'); ?>
        <?php echo $form->textField($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'deleted'); ?>
        <?php echo $form->checkBox($model, 'deleted'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'notes'); ?>
        <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'model'); ?>
        <?php echo $form->textField($model, 'model', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'model_id'); ?>
        <?php echo $form->textField($model, 'model_id', array('size' => 20, 'maxlength' => 20)); ?>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('D1filesModule.crud', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->

<?php
    $this->setPageTitle(
        Yii::t('D2filesModule.model', 'D2files')
        . ' - '
        . Yii::t('D2filesModule.crud_static', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
$this->breadcrumbs[Yii::t('D2filesModule.model','D2files')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id' => $model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('D2filesModule.crud_static', 'View');
?>

<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
    <h1>
        <?php echo Yii::t('D2filesModule.model','D2files')?>
        <small>
            <?php echo $model->itemLabel ?>

        </small>

        </h1>



<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>


<div class="row">
    <div class="span7">
        <h2>
            <?php echo Yii::t('D2filesModule.crud_static','Data')?>            <small>
                #<?php echo $model->id ?>            </small>
        </h2>

        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                array(
                        'name' => 'id',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'id',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
        array(
                    'name' => 'type',
                    'value' => $model->getEnumLabel('type',$model->type),
        ),
array(
                        'name' => 'file_name',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'file_name',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'upload_path',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'upload_path',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'add_datetime',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'add_datetime',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'user_id',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'user_id',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'deleted',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'deleted',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'notes',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'notes',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'model',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'model',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
array(
                        'name' => 'model_id',
                        'type' => 'raw',
                        'value' => $this->widget(
                            'TbEditableField',
                            array(
                                'model' => $model,
                                'attribute' => 'model_id',
                                'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            ),
                            true
                        )
                    ),
           ),
        )); ?>
        
<fieldset>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
          'id' => 'somemodel-form',
          'enableAjaxValidation' => false,
            //This is very important when uploading files
          'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
      ?>    
        <div class="row">

        </div>
        <!-- Other Fields... -->
        <div class="row">
            <?php //echo $form->labelEx($model,'photos'); ?>
            <?php
            $this->widget( 'vendor.dbrisinajumi.xupload.XUpload', array(
                'url' => Yii::app( )->createUrl( "/controller/upload"),
                //our XUploadForm
                'model' => $photos,
                //We set this for the widget to be able to target our own form
                'htmlOptions' => array('id'=>'somemodel-form'),
                'attribute' => 'file',
                'multiple' => true,
                //Note that we are using a custom view for our widget
                //Thats becase the default widget includes the 'form' 
                //which we don't want here
                'formView' => 'vendor.dbrisinajumi.d2files.views.d2files.view',
                )    
            );
            ?>
        </div>
        <button type="submit">Submit</button>
    <?php $this->endWidget(); ?>
</fieldset>        
    </div>


    <div class="span5">
        <div class="well">
            <?php $this->renderPartial('_view-relations',array('model' => $model)); ?>        </div>
    </div>
</div>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
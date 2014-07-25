<?php
Yii::import('vendor.dbrisinajumi.d2files.D2filesModule');
Yii::import('vendor.dbrisinajumi.d2files.controllers.D2filesController');

$D2FilesControler = new D2filesController('d2files/d2files');
?>

<div class="table-header">
<?php echo Yii::t('D2filesModule.crud_static', 'Attachments'); ?>
</div>
<?php
    
    $this->widget(
        'TbDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => Yii::t("D2filesModule.crud_static","Drop files to upload"),
                'type' => 'raw',
                'template' => $this->widget(
                    'vendor.dbrisinajumi.d2files.widgets.d2Upload',
                    array(
                        'action' => 'template',
                        'model_name'=> get_class($model),
                        //'model_name'=> Yii::app()->controller->id,
                        'model_id' => $model->getPrimaryKey(),
                        'controler' => $D2FilesControler,


                        ),
                    true
                    ),
                'value' => $this->widget("bootstrap.widgets.TbButton", array(
                    "label"=>Yii::t("D2filesModule.crud_static","Add file"),
                    "icon"=>"icon-upload-alt",
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'onclick' => '$("#fileupload").trigger("click");'
                     ),

                ),true)
                ,

            ),
        ),
    ));
?>

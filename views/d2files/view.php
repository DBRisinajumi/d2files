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
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("D2filesModule.crud_static","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>(Yii::app()->user->checkAccess("D2files.D2files.*") || Yii::app()->user->checkAccess("D2files.D2files.View")),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("D2filesModule.crud_static","Back"),
                )
 ),true);
    
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2filesModule.model','D2files');?>                <small><?php echo$model->itemLabel?></small>
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("D2filesModule.crud_static","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("D2filesModule.crud_static","Do you want to delete this item?")
                ),
                "visible"=> (Yii::app()->request->getParam("id")) && (Yii::app()->user->checkAccess("D2files.D2files.*") || Yii::app()->user->checkAccess("D2files.D2files.Delete"))
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">
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
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'id',
                            'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'type_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            'source' => CHtml::listData(D2filesType::model()->findAll(array('limit' => 1000)), 'id', 'itemLabel'),
                            'attribute' => 'type_id',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'file_name',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
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
                        'EditableField',
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
                        'EditableField',
                        array(
                            'model' => $model,
                            'type' => 'datetime',
                            'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                            'attribute' => 'add_datetime',
                            //'placement' => 'right',
                        ),
                        true
                    )
                ),

                array(
                    'name' => 'user_id',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
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
                        'EditableField',
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
                        'EditableField',
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
                        'EditableField',
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
                        'EditableField',
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
    </div>

    </div>
    <div class="row">
    
</div>

<?php echo $cancel_buton; ?>
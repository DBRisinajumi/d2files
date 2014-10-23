<?php
$this->setPageTitle(
    Yii::t('D2filesModule.model', 'D2files')
    . ' - '
    . Yii::t('D2filesModule.crud_static', 'Manage')
);

$this->breadcrumbs[] = Yii::t('D2filesModule.model', 'D2files');

?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('D2filesModule.crud_static','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>(Yii::app()->user->checkAccess('D2files.D2files.*') || Yii::app()->user->checkAccess('D2files.D2files.Create'))
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2filesModule.model', 'D2files');?>            </h1>
        </div>
    </div>
</div>

<?php Yii::beginProfile('D2files.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'd2files-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{summary}{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'columns' => array(
            array(
                'class' => 'CLinkColumn',
                'header' => '',
                'labelExpression' => '$data->itemLabel',
                'urlExpression' => 'Yii::app()->controller->createUrl("view", array("id" => $data["id"]))'
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'type_id',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    'source' => CHtml::listData(D2filesType::model()->findAll(array('limit' => 1000)), 'id', 'itemLabel'),
                    //'placement' => 'right',
                )
            ),
            array(
                //varchar(255)
                'class' => 'editable.EditableColumn',
                'name' => 'file_name',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'upload_path',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'add_datetime',
                'editable' => array(
                    'type' => 'datetime',
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'user_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'deleted',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'notes',
                'editable' => array(
                    'type' => 'textarea',
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            /*
            array(
                //varchar(50)
                'class' => 'editable.EditableColumn',
                'name' => 'model',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'model_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                ),
                'htmlOptions' => array(
                    'class' => 'numeric-column',
                ),
            ),
            */

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("D2files.D2files.View")'),
                    'update' => array('visible' => 'FALSE'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2files.D2files.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
                'deleteConfirmation'=>Yii::t('D2filesModule.crud_static','Do you want to delete this item?'),                    
                'viewButtonOptions'=>array('data-toggle'=>'tooltip'),   
                'deleteButtonOptions'=>array('data-toggle'=>'tooltip'),   
            ),
        )
    )
);
?>
<?php Yii::endProfile('D2files.view.grid'); ?>
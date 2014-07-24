<?php
$this->setPageTitle(
    Yii::t('D2filesModule.model', 'D2files')
    . ' - '
    . Yii::t('D2filesModule.crud_static', 'Manage')
);

$this->breadcrumbs[] = Yii::t('D2filesModule.model', 'D2files');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update(
            'd2files-grid',
            {data: $(this).serialize()}
        );
        return false;
    });
    ");
?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
    <h1>

        <?php echo Yii::t('D2filesModule.model', 'D2files'); ?>
        <small><?php echo Yii::t('D2filesModule.crud_static', 'Manage'); ?></small>

    </h1>


<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
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
                'class' => 'TbEditableColumn',
                'name' => 'id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'type',
                'value' => '$data->getEnumLabel(\'type\',$data->type)',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    'source' => $model->getEnumFieldLabels('type'),
                    //'placement' => 'right',
                ),
               'filter' => $model->getEnumFieldLabels('type'),
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'file_name',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            #'upload_path',
            array(
                'class' => 'TbEditableColumn',
                'name' => 'add_datetime',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'user_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'deleted',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            #'notes',
            array(
                'class' => 'TbEditableColumn',
                'name' => 'model',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'model_id',
                'editable' => array(
                    'url' => $this->createUrl('/d2files/d2files/editableSaver'),
                    //'placement' => 'right',
                )
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("D2files.D2files.View")'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("D2files.D2files.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D2files.D2files.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
            ),
        )
    )
);
?>
<?php Yii::endProfile('D2files.view.grid'); ?>
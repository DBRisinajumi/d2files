<?php
$this->setPageTitle(
    Yii::t('D1filesModule.model', 'D1files')
    . ' - '
    . Yii::t('D1filesModule.crud', 'Manage')
);

$this->breadcrumbs[] = Yii::t('D1filesModule.model', 'D1files');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update(
            'd1files-grid',
            {data: $(this).serialize()}
        );
        return false;
    });
    ");
?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
    <h1>

        <?php echo Yii::t('D1filesModule.model', 'D1files'); ?>
        <small><?php echo Yii::t('D1filesModule.crud', 'Manage'); ?></small>

    </h1>


<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php Yii::beginProfile('D1files.view.grid'); ?>


<?php
$this->widget('TbGridView',
    array(
        'id' => 'd1files-grid',
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
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'editable.EditableColumn',
                'name' => 'type',
                'value' => '$data->getEnumLabel(\'type\',$data->type)',
                'editable' => array(
                    'type' => 'select',
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    'source' => $model->getEnumFieldLabels('type'),
                    //'placement' => 'right',
                ),
               'filter' => $model->getEnumFieldLabels('type'),
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'file_name',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            #'upload_path',
            array(
                'class' => 'TbEditableColumn',
                'name' => 'add_datetime',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'user_id',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'deleted',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            #'notes',
            array(
                'class' => 'TbEditableColumn',
                'name' => 'model',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),
            array(
                'class' => 'TbEditableColumn',
                'name' => 'model_id',
                'editable' => array(
                    'url' => $this->createUrl('/d1files/d1files/editableSaver'),
                    //'placement' => 'right',
                )
            ),

            array(
                'class' => 'TbButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'Yii::app()->user->checkAccess("D1files.D1files.View")'),
                    'update' => array('visible' => 'Yii::app()->user->checkAccess("D1files.D1files.Update")'),
                    'delete' => array('visible' => 'Yii::app()->user->checkAccess("D1files.D1files.Delete")'),
                ),
                'viewButtonUrl' => 'Yii::app()->controller->createUrl("view", array("id" => $data->id))',
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("update", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("delete", array("id" => $data->id))',
            ),
        )
    )
);
?>
<?php Yii::endProfile('D1files.view.grid'); ?>
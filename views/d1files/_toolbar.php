<?php Yii::beginProfile('D1files.view.toolbar'); ?>

<?php
    $showDeleteButton = (Yii::app()->request->getParam("id"))?true:false;
    $showManageButton = true;
    $showCreateButton = true;
    $showUpdateButton = true;
    $showCancelButton = true;
    $showSaveButton   = true;
    $showViewButton   = true;

    switch($this->action->id){
        case "admin":
            $showCancelButton = false;
            $showSaveButton   = false;
            $showViewButton   = false;
            $showUpdateButton = false;
            break;
        case "update":
            $showCreateButton = false;
            $showUpdateButton = false;
            break;
        case "create":
            $showCreateButton = false;
            $showViewButton   = false;
            $showUpdateButton = false;
            break;
        case "view":
            $showViewButton   = false;
            $showSaveButton   = false;
            $showCreateButton = false;
            break;
    }
?>
<div class="clearfix">
    <div class="btn-toolbar pull-right">
        <!-- relations -->
        
        <div class="btn-group">
            <?php
             $this->widget("bootstrap.widgets.TbButton", array(
                           "label"=>Yii::t("D1filesModule.crud","Manage"),
                           "icon"=>"icon-list-alt",
                           "size"=>"large",
                           "url"=>array("admin"),
                           "visible"=>$showManageButton && (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.View"))
                        ));
         ?>        </div>
    </div>

    <div class="btn-toolbar pull-left">
        <div class="btn-group">
            <?php
                   $this->widget("bootstrap.widgets.TbButton", array(
                       #"label"=>Yii::t("D1filesModule.crud","Cancel"),
                       "icon"=>"chevron-left",
                       "size"=>"large",
                       "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
                       "visible"=>$showCancelButton && (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.View")),
                       "htmlOptions"=>array(
                                       "class"=>"search-button",
                                       "data-toggle"=>"tooltip",
                                       "title"=>Yii::t("D1filesModule.crud","Cancel"),
                                   )
                    ));
                   $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("D1filesModule.crud","Create"),
                        "icon"=>"icon-plus",
                        "size"=>"large",
                        "type"=>"success",
                        "url"=>array("create"),
                        "visible"=>$showCreateButton && (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.Create"))
                   ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("D1filesModule.crud","Delete"),
                        "type"=>"danger",
                        "icon"=>"icon-trash icon-white",
                        "size"=>"large",
                        "htmlOptions"=> array(
                            "submit"=>array("delete","id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                            "confirm"=>Yii::t("D1filesModule.crud","Do you want to delete this item?")
                        ),
                        "visible"=> $showDeleteButton && (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.Delete"))
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        #"label"=>Yii::t("D1filesModule.crud","Update"),
                        "icon"=>"icon-edit icon-white",
                        "type"=>"primary",
                        "size"=>"large",
                        "url"=>array("update","id"=>$model->{$model->tableSchema->primaryKey}),
                        "visible"=> $showUpdateButton &&  (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.Update"))
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                        #"label"=>Yii::t("D1filesModule.crud","View"),
                        "icon"=>"icon-eye-open",
                        "size"=>"large",
                        "url"=>array("view","id"=>$model->{$model->tableSchema->primaryKey}),
                        "visible"=>$showViewButton &&  (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.View")),
                        "htmlOptions"=>array(
                                      "data-toggle"=>"tooltip",
                                      "title"=>Yii::t("D1filesModule.crud","View Mode"),
                        )
                    ));
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("D1filesModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                       "visible"=>$showSaveButton &&  (Yii::app()->user->checkAccess("D1files.D1files.*") || Yii::app()->user->checkAccess("D1files.D1files.View"))
                    ));
             ?>        </div>
        <?php if($this->action->id == 'admin'): ?>        <div class="btn-group">
            
            <?php
                $this->widget(
                       "bootstrap.widgets.TbButton",
                       array(
                           #"label"=>Yii::t("D1filesModule.crud","Search"),
                                   "icon"=>"icon-search",
                                   "size"=>"large",
                                   "htmlOptions"=>array(
                                       "class"=>"search-button",
                                       "data-toggle"=>"tooltip",
                                       "title"=>Yii::t("D1filesModule.crud","Advanced Search"),
                                   )
                           )
                       );
                    ?>
                    <?php
                $this->widget(
                       "bootstrap.widgets.TbButton",
                       array(
                           #"label"=>Yii::t("D1filesModule.crud","Clear"),
                                   "icon"=>"icon-remove-sign",
                                   "size"=>"large",
                                   "url"=>Yii::app()->baseURL."/".Yii::app()->request->getPathInfo(),
                                   "htmlOptions"=>array(
                                      "data-toggle"=>"tooltip",
                                      "title"=>Yii::t("D1filesModule.crud","Clear Search"),
                                   )
                           )
                       );
                    ?>
                            </div>
        <?php endif; ?>
    </div>


</div>


<?php if($this->action->id == 'admin'): ?><div class="search-form" style="display:none">
    <?php Yii::beginProfile('D1files.view.toolbar.search'); ?>    <?php $this->renderPartial('_search',array('model' => $model,)); ?>
    <?php Yii::endProfile('D1files.view.toolbar.search'); ?></div>
<?php endif; ?>
<?php Yii::endProfile('D1files.view.toolbar'); ?>
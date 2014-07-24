# d2files (cloned from d1files)


## Features

* attach files to model record
* widget for model view

## Installation
 * install https://github.com/blueimp/jQuery-File-Upload?source=c
 * install https://github.com/DBRisinajumi/d2files.git
```bash
php composer.phar require dbrisinajumi/d2files dev-master
```

 * add to config/main.php
```php
     'import' => array(
        'vendor.dbrisinajumi.d2files.models.*',
    ),
    'modules' => array(
        'd2files' => array(
             'class' => 'vendor.dbrisinajumi.d2files.D1filesModule',
             'upload_dir' => 'root.upload',
         ),  
	 ),
```

## Usage
### controler
* add to access rules follow actions: 'upload','deleteFile','downloadFile'
* add actions
```php
<?php

    public function actionUpload($model_id ) {

        Yii::import( "vendor.dbrisinajumi.d2files.compnents.*");
        $oUploadHandler = new UploadHandlerD1files(
                        array(
                            'model_name' => 'model....',
                            'model_id' => $model_id,
                            'accept_file_types' => '/\.(gif|pdf|dat|jpe?g|png)$/i',
                        )
        );

    }

    public function actionDeleteFile($id) {
        Yii::import( "vendor.dbrisinajumi.d2files.compnents.*");        
        UploadHandlerD1files::deleteFile($id);
    }

    public function actionDownloadFile($id) {
        
        $m = D1files::model();
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested record in d2files does not exist.');
        }
        
        Yii::import( "vendor.dbrisinajumi.d2files.compnents.*");
        $oUploadHandler = new UploadHandlerD1files(
                        array(
                            'model_name' => 'model....',
                            'model_id' => $id,
                            'download_via_php' => TRUE,
                            'file_name' => $model->file_name,
                        )
        );  
    }    

```

### VIEW
```php

        $this->widget(
             'TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => Yii::t('FuelingModule.crud', 'Attachments'),
                    'type'   => 'raw',
                    'template'   =>  $this->widget(
                                        'vendor.dbrisinajumi.d2files.widgets.d1Upload',
                                        array(
                                            'controler' => $this,
                                            'model_id' => $model->getPrimaryKey(),
                                            'action' => 'template',
                                            ),
                                        true
                                        ),
                    'value'  => $this->widget("bootstrap.widgets.TbButton", array(
                        "label"=>Yii::t("FuelingModule.crud_static","Add file"),
                        "icon"=>"icon-plusthick",
                        'htmlOptions' => array(
                            'data-toggle' => 'modal',
                            'onclick' => '$("#fileupload").trigger("click");'
                         ),

                    ),true)
                    ,

                ),
```

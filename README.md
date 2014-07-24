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
        'vendor.dbrisinajumi.d2files.widgets.*', // shared classes
    ),
    'modules' => array(
        'd2files' => array(
             'class' => 'vendor.dbrisinajumi.d2files.D2filesModule',
             'upload_dir' => 'root.upload',
             'accept_file_types' => '/\.(gif|pdf|dat|jpe?g|png|doc|docx|xls|xlsx|htm)$/i',
         ),  
	 ),
```

## Usage
### VIEW
```php
    $this->widget('d2FilesWidget',array('model'=>$model));
```

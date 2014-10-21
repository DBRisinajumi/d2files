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
            
            //automaticly registre tasks, when upload files to model 
            // d2person.PprsPerson, if user role is Agent or Client
            'registre_tasks_to_models' => array(
                'd2person.PprsPerson' => array(
                    'new_project_status' => 1, //Not started
                    'task_init_status' => 1, //Active
                    'task_due_in_days' => 3,
                    'user_roles' => array('Agent','Client'),
                    ),
            ),
         ),  
	 ),
```

## Usage
### VIEW
```php
    $this->widget('d2FilesWidget',array('module'=>$this->module->id, 'model'=>$model));
```

### Requirements
* To upload file user must have "ModuleName.ModelName.create" access rights for caller module
* To delete file user must have "ModuleName.ModelName.delete" access rights for caller module
* To download, upload or delete file user must have read access to corresponding item it is attached to

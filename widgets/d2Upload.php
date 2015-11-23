<?php

class d2Upload extends CWidget {

	public $template_view = "template";
	
    public $action = 'value';
    public $model_name;
    public $model_id;
    public $d2files_model;
    public $controler;
    public $readOnly = false;
    public $widgetId = false;
    private $files_types = array();
    
    public function getId($autoGenerate=true)
	{
        return $this->widgetId;
	}    

	public function init(){
        
        $this->files_types = $this->loadFilesType();
        $this->registerClientScripts();
	}

	public function run(){

        
        $model_files = new D2files('search');
        $model_files->model = $this->model_name;
        $model_files->model_id = $this->model_id;
        $model_files->deleted = 0;
        $files = $model_files->findAll($model_files->searchExactCriteria());

        $this->render($this->template_view, array(
            'files' => $files,
            'model' => $model_files->model,
            'files_types_list' => $this->files_types,
            'readOnly' => $this->readOnly,
        ));                

        
	}

    private function loadFilesType(){
        $files_types = D2filesType::model()->findAll(
            array(
                'condition' => 'model = "' . $this->model_name . '"',
                'limit' => 1000
            ));

        $t_listData = array();
        foreach ($files_types as $ft) {
            $t_listData[$ft['id']] = Yii::t('d2files', $ft['type']);
        }   

        return $t_listData;
    }
    
	private function registerClientScripts() {
        
        $baseUrl = Yii::app()->baseUrl; 
        
        //blueimp/jQuery-File-Upload scripts
        $assetsPath = Yii::getPathOfAlias('vendor.blueimp.jquery-file-upload');
        $cs = Yii::app()->getClientScript();
        $am = Yii::app()->assetManager;
        $cs->registerScriptFile($am->publish($assetsPath.'/js/vendor/jquery.ui.widget.js'));
        $cs->registerScriptFile($am->publish($assetsPath.'/js/jquery.iframe-transport.js'));
        $cs->registerScriptFile($am->publish($assetsPath.'/js/jquery.fileupload.js'));
        
        //page scripts
        $file_upload_ajax_url = $this->controler->createUrl('upload', array(
            'model_name' => $this->model_name,
            'model_id' => $this->model_id,
        ));
        
        $file_delete_ajax_url = '';
        //if (Yii::app()->user->checkAccess($this->model_name . '.delete')) {
        if (!$this->readOnly && D2files::extendedCheckAccess($this->model_name . '.deleteD2File',FALSE)) {
            $file_delete_ajax_url = '+ \'<a href="'.$this->controler->createUrl('deleteFile').'&id=\'+file.id+\'" rel="tooltip" title="'.Yii::t("D2filesModule.crud_static","Delete").'" class="delete" data-toggle="tooltip"><i class="icon-trash"></i></a> \'';
        }
        
        $file_download_ajax_url = $this->controler->createUrl('downloadFile');
        
        $file_editable_url = $this->controler->createUrl('/d2files/d2files/editableSaver');
        
        $comments_row = '';
        if (!$this->readOnly && D2files::extendedCheckAccess($this->model_name . '.uploadD2File', false)) {
            if(!empty($this->files_types)){
                $comments_row .= '<tr id="d2cmnt-\'+file.id+\'"><td colspan="3">';
            }else{
                $comments_row .= '<tr id="d2cmnt-\'+file.id+\'"><td colspan="2">';
            }
            $comments_row .= '<a class="notes_editable" href="#" rel="D2files_notes_\'+file.id+\'" data-pk="\'+file.id+\'"></a>';
            $comments_row .= '</td></tr>';
        }

        if(!$this->readOnly){
            $file_type_js = '';
            $file_type_editable = '';

            if(!empty($this->files_types)){
                $file_type_js = '+ \'<td class="file-type"><a class="type_editable" href="#" rel="D2files_type_id_\'+file.id+\'" data-pk="\'+file.id+\'"></a></td>\'';
                $t_listData = array();
                foreach ($this->files_types as $key => $item) {
                    $t_listData[] = "{'value':" . $key . ",'text':'" . Yii::t('d2files', $item) . "'}";
                }
                $s_listData = implode(',', $t_listData);            
                $file_type_editable = '                        
                    $(\'a.type_editable\').editable({
                                \'name\':\'type_id\',
                                \'title\':\'' . Yii::t("editable.editable", "Select") . ' ' . Yii::t("D2filesModule.model", "Type") . '\',
                                \'url\':\'' . $file_editable_url . '\',
                                \'type\':\'select\',
                                \'emptytext\':\'' . Yii::t("editable.editable", "Empty") . '\',
                                \'params\':{\'scenario\':\'update\'},
                                \'source\':[' . $s_listData . ']
                            });
                            ';            
            }

            Yii::app()->clientScript->registerScript('for_fileupload_'.$this->getId(),'
                    $("#fileupload_'.$this->getId().'").hide();
                    $("#fileupload_'.$this->getId().'").fileupload({
                        dataType: "json",
                        url : "'.$file_upload_ajax_url.'",                    
                        dropZone : "#dropZone_'.$this->getId().'",
                        done: function (e, data) {
                            $.each(data.result, function (index, file) {
                                if (file.error != undefined && file.error != "") {
                                    alert(file.error);
                                    return;
                                }
                                var sRow = 
                                \'<tr id="d2file-\'+file.id+\'">\'
                                + \'<td>\'
                                  + \'<a href="'.$file_download_ajax_url.'&id=\'+file.id+\'" rel="tooltip" title="'.Yii::t("D2filesModule.crud_static","Download").'" class="download" data-toggle="tooltip">\'
                                    + \'<i class="icon-file-text blue"></i> \' + file.name + \'</a></td>\'
                                ' . $file_type_js . '
                                + \'<td class="button-column">\'
                                ' . $file_delete_ajax_url . '
                                + \'</td>\'
                                + \'</tr>\'
                                + \'' . $comments_row . '\'
                                ;
                                if ($("#attachment_list_'.$this->getId().' tr").length > 0) {
                                    $("#attachment_list_'.$this->getId().' tr:last").after(sRow);
                                } else {
                                    $("#attachment_list_'.$this->getId().'").append(sRow);
                                }
                            });

                            ' . $file_type_editable . ' 

                            $(\'a.notes_editable\').editable({
                                \'name\':\'notes\',
                                \'title\':\'' . Yii::t("D2filesModule.editable", "Enter") . ' ' . Yii::t("D2filesModule.model", "Notes") . '\',
                                \'url\':\'' . $file_editable_url . '\',
                                \'type\':\'textarea\',
                                \'placement\':\'right\',
                                \'emptytext\':\'' . Yii::t("D2filesModule.crud_static", "Add comment") . '\',
                                \'params\':{\'scenario\':\'update\'}
                            });

                        }
                });
                $("#attachment_list_'.$this->getId().'").on( "click", "a.delete", function() {
                    if (!confirm("' . Yii::t("D2filesModule.crud", "Do you want to delete this item?") . '")) {
                        return false;
                    }
                    var elTr = $(this).parent().parent();
                    var cmtTr = $("#d2cmnt-" + elTr.attr("id").split("-")[1]);

                    $.ajax({
                        type: "POST",
                        url: $(this).attr("href"),

                        success: function(data){
                            $(elTr).remove();
                            $(cmtTr).remove();
                        }
                    });
                    return false; // stop the browser following the link
                });
                '
            );
        }
        
	}
}
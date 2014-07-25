<?php

class d2Upload extends CWidget {

	public $template_view = "template";
	
    public $action = 'value';
    public $model_name;
    public $model_id;
    public $d2files_model;
    public $controler;
    

	public function init(){
        $this->registerClientScripts();
	}

	public function run(){

        
        $model_files = new D2files('search');
        $model_files->model = $this->model_name;
        $model_files->model_id = $this->model_id;
        $model_files->deleted = 0;
        $files = $model_files->findAll($model_files->searchExactCriteria());

        $this->render($this->template_view,array(
            'files' => $files,
        ));                

        
	}

	private function registerClientScripts(){
        
        $baseUrl = Yii::app()->baseUrl; 
        
        //blueimp/jQuery-File-Upload scripts
        $assetsPath = Yii::getPathOfAlias('vendor.blueimp.jquery-file-upload');
        $cs = Yii::app()->getClientScript();
        $am = Yii::app()->assetManager;
        $cs->registerScriptFile($am->publish($assetsPath.'/js/vendor/jquery.ui.widget.js'));
        $cs->registerScriptFile($am->publish($assetsPath.'/js/jquery.iframe-transport.js'));
        $cs->registerScriptFile($am->publish($assetsPath.'/js/jquery.fileupload.js'));

        //page scripts
        $file_upload_ajax_url = $this->controler->createUrl('upload',array(
            'model_name' => $this->model_name,
            'model_id' => $this->model_id,
        ));
        $file_delete_ajax_url = $this->controler->createUrl('deleteFile');        
        $file_download_ajax_url = $this->controler->createUrl('downloadFile');        
        Yii::app()->clientScript->registerScript('for_fileupload','
                $("#fileupload").hide();
                $("#fileupload").fileupload({
                    dataType: "json",
                    url : "'.$file_upload_ajax_url.'",                    
                    dropZone : "tr.dropZone",
                    done: function (e, data) {
                        $.each(data.result, function (index, file) {
                            if (file.error != undefined && file.error != "") {
                                alert(file.error);
                                return;
                            }
                            var sRow = 
                            \'<tr><td><i class="icon-file-text blue"></i> \' + file.name + \'</a></td>\'
                            + \'<td class="button-column">\'
                            + \'<a href="'.$file_delete_ajax_url.'&id=\'+file.id+\'" rel="tooltip" title="'.Yii::t("D2finvModule.crud_static","Delete").'" class="delete" data-toggle="tooltip"><i class="icon-trash"></i></a> \'
                            + \'<a href="'.$file_download_ajax_url.'&id=\'+file.id+\'" rel="tooltip" title="'.Yii::t("D2finvModule.crud_static","Download").'" class="download" data-toggle="tooltip"><i class="icon-download-alt"></i></a>\'
                            + \'</td>\'
                            + \'</tr>\'
                            ;
                            if($("#attachment_list tr").length > 0){
                                $("#attachment_list tr:last").after(sRow);
                            }else{
                                $("#attachment_list").append(sRow);
                            }
                        });

                    }
            });
            $("#attachment_list").on( "click", "a.delete", function() {
                if (!confirm("'.Yii::t("D2finvModule.crud","Do you want to delete this item?").'")) {
                    return false;
                }
                var elTr = $(this).parent().parent();
                $.ajax({
                  type: "POST",
                  url: $(this).attr("href"),
                  
                  success: function(data){
                   $(elTr).remove();
                  }
                });
                return false; // stop the browser following the link
            });
            '
        );
      

	}
}
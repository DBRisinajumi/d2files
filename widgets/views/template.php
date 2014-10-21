<?php
    if (Yii::app()->user->checkAccess($model . '.downloadD2File')) {
        $sFileListHtml = '<table id="attachment_list" class="items table table-condensed table-bordered">';
        
        foreach ($files as $mfile) {
            
            $file_delete_ajax_url = '';
            if (Yii::app()->user->checkAccess($model . '.deleteD2File')) {
                $delete_url = $this->controler->createUrl('deleteFile',array(
                    'id' => $mfile->id,
                ));
                $file_delete_ajax_url = '<a href="'.$delete_url.'" rel="tooltip" title="'.Yii::t("D2filesModule.crud_static","Delete").'" class="delete" data-toggle="tooltip"><i class="icon-trash"></i></a> ';
            }
            
            $file_download_ajax_url = $this->controler->createUrl('downloadFile',array(
                'id' => $mfile->id,
            ));

            $sFileListHtml .= '<tr>'
                    . '<td><i class="icon-file-text blue"></i> '.$mfile->file_name.'</td>'
                    . '<td class="button-column">'
                    . '<a href="'.$file_download_ajax_url.'" rel="tooltip" title="'.Yii::t("D2filesModule.crud_static","Download").'" class="download" data-toggle="tooltip"><i class="icon-download-alt"></i></i></a> '
                    . $file_delete_ajax_url
                    . '</td>'
                    . '</tr>';
        }
        $sFileListHtml .= '</table>';
    }    
        $file_form = '<form method="post" id="d2FileUploadForm" name="DataForm" action="" enctype="multipart/form-data">'.
                                '<input id="fileupload" type="file" name="files[]"  multiple />
                                '.$sFileListHtml.'
                                </form>';
        
        if (Yii::app()->user->checkAccess($model . '.uploadD2File')) {
            echo "<tr class=\"dropZone\" style=\"border: 3px dashed #ccc;\"><th style=\"vertical-align: middle; width: 220px; padding-left:10px;\"><span class=\"bigger-110 bolder\"><i class=\"icon-cloud-upload grey\"></i> {label}</span></th><td>{value}</td></tr>\n";
        }
        echo "<tr><td colspan=\"2\">".$file_form."</td></tr>\n";
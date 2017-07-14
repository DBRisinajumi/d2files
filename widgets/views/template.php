<?php

$sFileListHtml = '<table id="attachment_list_'.$this->getId().'" class="items table table-condensed table-bordered">';
if (D2files::extendedCheckAccess($model . '.downloadD2File', false)) {
    $colspan = 3;
    if(empty($files_types_list)){
        $colspan = 2;
    }
    //file list
    foreach ($files as $mfile) {
        
        //editable file type
        $file_type = '';
        if(!empty($files_types_list)){
            $file_type_html = '';
            if($readOnly){
                $file_type_html = $this->widget(
                        'EditableField',
                        array(
                            'model' => $mfile,
                            'type' => 'select',
                            'attribute' => 'type_id',
                            'url' => Yii::app()->controller->createUrl('/d2files/d2files/editableSaver'),
                            'source' => $files_types_list,
                            'placement' => 'left',
                        ),
                        true
                    ); 
            }elseif($mfile->type_id){
                $file_type_html = $files_types_list[$mfile->type_id];
            }
            $file_type = '<td class="file-type">' . $file_type_html . '</td>';
        }
        
        $file_delete_ajax_url = '';
        if (!$readOnly && D2files::extendedCheckAccess($model . '.deleteD2File', false)) {
            $delete_url = $this->controler->createUrl('deleteFile', array('id' => $mfile->id),'&amp;');
            $file_delete_ajax_url = '<a href="' . $delete_url . '" rel="tooltip" title="' . Yii::t("D2filesModule.crud_static", "Delete") . '" class="delete" data-toggle="tooltip"><i class="icon-trash"></i></a> ';
        }

        $file_download_ajax_url = $this->controler->createUrl('downloadFile', array('id' => $mfile->id),'&amp;');

        $imageHtml = '';
        if($showImagesTypes && preg_match($showImagesTypes,$mfile->file_name)){
            $imageHtml = '<img src="' . $file_download_ajax_url . '">';

        }

        $sFileListHtml .= '<tr id="d2file-' . $mfile->id . '">'
                . '<td>'
                    .'<a href="' . $file_download_ajax_url . '" rel="tooltip" title="' . Yii::t("D2filesModule.crud_static", "Download") . '" class="download" data-toggle="tooltip">'
                        .'<i class="icon-file-text blue"></i> '
                        . $mfile->file_name
                    . '</a>'
                    . $imageHtml
                    .'</td>'
                . $file_type
                . '<td class="button-column">'
                . $file_delete_ajax_url
                . '</td>'
                . '</tr>';
        
        if (D2files::extendedCheckAccess($model . '.uploadD2File', false)) {
        
            $sFileListHtml .= '<tr id="d2cmnt-' . $mfile->id . '"><td colspan="'.$colspan.'">';
            
            $sFileListHtml .= $this->widget(
                'EditableField',
                array(
                    'model' => $mfile,
                    'attribute' => 'notes',
                    'url' => Yii::app()->controller->createUrl('/d2files/d2files/editableSaver'),
                    'emptytext' => Yii::t("D2filesModule.crud_static", "Add comment"),
                    'placement' => 'right',
                    'apply' =>  !$readOnly,
                ),
                true
            );

            $sFileListHtml .= '</td></tr>';
        
        }
        
    }
}
$sFileListHtml .= '</table>';

$file_form = '<form method="post" id="d2FileUploadForm_'.$this->getId().'" name="DataForm" enctype="multipart/form-data">' .
        '<input id="fileupload_'.$this->getId().'" type="file" name="files[]"  style="display: none;" multiple />
                                ' . $sFileListHtml . '
                                </form>';

if (!$readOnly && D2files::extendedCheckAccess($model . '.uploadD2File', false)) {
    echo "<tr id=\"dropZone_".$this->getId()."\" style=\"border: 3px dashed #ccc;\"><th style=\"vertical-align: middle; width: 220px; padding-left:10px;\"><span class=\"bigger-110 bolder\"><i class=\"icon-cloud-upload grey\"></i> {label}</span></th><td>{value}</td></tr>\n";
}
echo "<tr><td>" . $file_form . "</td></tr>\n";

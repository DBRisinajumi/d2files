<?
        $sFileListHtml = '<table id="attachment_list" class="items table table-condensed table-bordered">';
        foreach ($files as $mfile) {
            
            $file_delete_ajax_url = $this->controler->createUrl('deleteFile',array(
                'id' => $mfile->id,
            ));
            $file_download_ajax_url = $this->controler->createUrl('downloadFile',array(
                'id' => $mfile->id,
            ));

            $sFileListHtml .= '<tr>'
                    . '<td>'.$mfile->file_name.'</td>'
                    . '<td class="button-column">'
                    . '<a href="'.$file_delete_ajax_url.'" rel="tooltip" title="'.Yii::t("D1filesModule","Delete").'" class="delete"><i class="icon-trash"></i></a>'
                    . '<a href="'.$file_download_ajax_url.'" rel="tooltip" title="'.Yii::t("D1filesModule","Download").'" class="download"><i class="icon-circle-arrow-up"></i></i></a>'
                    . '</td>'
                    . '</tr>';
        }
        $sFileListHtml .= '</table>';
        $file_form = '<form method="post" id="d1FileUploadForm" name="DataForm" action="" enctype="multipart/form-data">'.
                                '<input id="fileupload" type="file" name="files[]"  multiple />
                                '.$sFileListHtml.'
                                </form>';
        
        echo "<tr class=\"dropZone\"><th>{label}</th><td>{value}</td></tr>\n<tr class=\"dropZone\"><td colspan=\"2\">".$file_form."</td></tr>\n";
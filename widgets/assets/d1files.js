$(function(){
/**
     * file drag&drop
     */
    if ($.fn.fileupload) {
    $('#fileupload').fileupload({
        dataType: 'json',
        url : '/?mod=903&print=ajax',
        dropZone : '#attacment_list',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                var sRow = 
                '<a>' + file.name + '</a>'
                + '<input type="button" class="button-delete" title="Delete file">'
                + '<input type="hidden" value="'+file.d_file_id+'">'
                + '<br />'
                ;
                $('#attacment_list').append(sRow);
            });

        }
    });
    }
				
				
    /**
     *nonjem dra&drop no visa ekrāna
     */
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });

    /**
     * failu dzēšana
     */
    $('#attacment_list').on('click','.button-delete',function(e){
        if(!confirm('Vai tiešām vēlaties dzēst failu?'))
            return false;
        var elName = $(this).prev();
        var elDel = $(this);
        var elHidden = $(this).next();
        var elBr = $(this).next().next();
        $.post('/?mod=903&print=ajax',
        {
            action          : "del_file" ,
            d_file_id       : $(this).next().val()

        },
        function(data) {

            data = $.parseJSON(data);

            /**
            * kljudu apstade
            */
            if (data["error"]){
                $("#error_info").show();
                $("#error_info").html(data["error"]);
                return false;
            }

            /**
             * izdzesh HTML rindu
             */
            $(elName).remove();
            $(elDel).remove();
            $(elHidden).remove();
            $(elBr).remove();

        });

    });

    /**
     * failu atvēršana
     */
    $('#attacment_list').on('click','a',function(e){
        window.open('/?mod=903&print=ajax&action=show_file&d_file_id='+$(this).next().next().val());
    });
				
})	
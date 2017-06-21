//jQuery(function ($) {
$(document).ready(function () {
    $('#latpesanimport').hide();
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
        _title: function (title) {
            var $title = this.options.title || '&nbsp;'
            if (("title_html" in this.options) && this.options.title_html == true)
                title.html($title);
            else
                title.text($title);
        }
    }));
    var whitelist_ext = ["xlsx", ".xls"];
    var whitelist_mime = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-excel"];
    $('#file_data_transaksi').ace_file_input({
        style: 'well',
        btn_choose: 'Tarik Atau Klik Unggah Data',
        btn_change: null,
        no_icon: 'ace-icon fa fa-cloud-upload',
        droppable: true,
        allowExt: whitelist_ext,
        allowMime: whitelist_mime,
        thumbnail: 'fit'//small | large | fit
    })
    

})

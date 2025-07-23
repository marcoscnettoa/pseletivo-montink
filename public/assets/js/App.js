// # MXtera - App -
var APP = {
    load: function (){

        load_app_confirm($(".app-confirm"));
        load_selectpicker($(".selectpicker-st1"));
        load_datatable_st1($(".datatable-st1"));
        load_tags_st1($(".tags-st1"));
        load_input_file_accept_auto_validation($("input[type=\'file\']").filter('[accept]'));
        load_input_file_crop_image($(".file-crop-image"));
        load_input_file_remove($(".btn-preview-file-remove-input"));
        load_btn_input_password($('.btn-input-password-on-off'));
        load_btn_consulta_cep($('.btn-consulta-cep'));
        load_btn_consulta_cnpj($('.btn-consulta-cnpj'));
        load_change_uf_municipios($('.change-uf-municipios'), true);
        load_mask_cep($('.mask-cep'));
        load_mask_cnpj($('.mask-cnpj'));
        load_mask_cpf($('.mask-cpf'));
        load_mask_cei($('.mask-cei'));
        load_mask_telefone($('.mask-telefone'));
        load_mask_telefone_fixo($('.mask-telefone-fixo'));
        load_mask_data($('.mask-data'));
        load_mask_data_horas_n1($('.mask-data-hora-n1'));
        load_mask_data_horas_n2($('.mask-data-hora-n2'));
        load_mask_dinheiro_br_n1($('.mask-dinheiro-br-n1'));
        load_mask_porcentagem_n1($('.mask-porcentagem-n1'));
        load_mask_porcentagem_n2($('.mask-porcentagem-n1'));
        load_data_picker($('.data-picker'));
        load_box_repeat_table($('table.box-repeat-table'));
        load_box_repeat($('.box-repeat'));
        //load_data_time_picker($('.data-time-picker'));

    },
    log: true,
    consoleLog: function(v) {
        if(this.log){ console.log(v); }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    APP.load();
});

// # MXtera - Helpers -
var H = {
    load: function (){

    },
    redirect: function(url, method, enctype, data){
        const form  = $('<form style="display:none;">');
        form.attr('action', url);
        form.attr('method', method);
        form.attr('enctype', enctype);

        const in_token = $('<input>');
        in_token.attr('type','hidden');
        in_token.attr('name','_token');
        in_token.attr('value',$('meta[name="csrf-token"]').attr('content'));

        form.append(in_token);

        $.each(data, function(key, value) {
            const in_data = $('<input>');
            in_data.attr('type','hidden');
            in_data.attr('name',key);
            in_data.attr('value',value);
            form.append(in_data);
        });
        $('body').append(form);
        form.submit();
    }
}

// ! Mask -----
function load_mask_cpf(E) {
    $(E).mask('000.000.000-00');
}

function load_mask_cnpj(E) {
    $(E).mask('00.000.000/0000-00');
}

function load_mask_cei(E) {
    $(E).mask('00.000.00000/00');
}

function load_mask_cep(E) {
    $(E).mask('00000-000');
}

function load_mask_telefone_fixo(E) {
    $(E).mask('(00) 0000.0000');
}

function load_mask_telefone(E) {
    const maskBehavior = function(val){
        val = val.replace(/\D/g,'');
        return val.length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    };
    $(E).mask(maskBehavior, {
        onKeyPress: function(val, e, field, opts) {
            field.mask(maskBehavior(val), opts);
        }
    });
}

function load_mask_data(E) {
    $(E).mask('99/99/9999');
}

function load_mask_data_horas_n1(E) {
    $(E).mask('99/99/9999 99:99');
}

function load_mask_data_horas_n2(E) {
    $(E).mask('99/99/9999 99:99:99');
}

function load_mask_dinheiro_br_n1(E) {
    $(E).mask('000.000.000.000.000,00', { reverse: true });
}

function load_mask_numero_n1(E) {
    $(E).mask('00000000000000000', { reverse: true });
}

function load_mask_porcentagem_n1(E) {
    $(E).mask('000', { reverse: true });
}

function load_mask_porcentagem_n2(E) {
    $(E).mask('000,00', { reverse: true });
}

function load_data_picker(E){
    $(E).datepicker({ format: 'dd/mm/yyyy', language: 'pt-BR' });
}

function load_data_time_picker(E){
    //$(E).datepicker({ format: 'dd/mm/yyyy', language: 'pt-BR' });
}

// ! Alerta Confirma -| Swal
function load_app_confirm(E){
    $(E).on('click',function(){
        const _this         = $(this);
        const _token        = $("meta[name=\'csrf-token\']").attr('content');
        const href          = _this.data('href')?_this.data('href'):'';
        const hash          = _this.data('hash')?_this.data('hash'):'';
        const method        = _this.data('method')?_this.data('method'):'';
        const type          = _this.data('type')?_this.data('type'):'';
        const title         = _this.data('title')?_this.data('title'):'';
        const msg           = _this.data('msg')?_this.data('msg'):'';
        const btnConfirmTxt = _this.data('btnConfirmTxt')?_this.data('btnConfirmTxt'):'Sim';
        const btnCancelTxt  = _this.data('btCancelTxt')?_this.data('btCancelTxt'):'Não';
        // const btnConfirm    = _this.data('btnConfirm')?_this.data('btnConfirm'):true;
        // const btnCancel     = _this.data('btnCancel')?_this.data('btnCancel'):true;

        Swal.fire({
            title: title,
            html: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: btnConfirmTxt,
            cancelButtonText: btnCancelTxt,
            confirmButtonColor: '#0076ff',
            reverseButtons: true
        }).then((result)=>{
            if(result.isConfirmed){
                let form            = document.createElement('form');
                form.style.display  = 'none';
                form.method         = (method.toUpperCase()=='GET'?'GET':'POST');
                form.action         = href;
                let in_token        = document.createElement('input');
                in_token.type       = "hidden";
                in_token.name       = "_token";
                in_token.value      = _token;
                form.appendChild(in_token);
                if(method.toUpperCase()!='GET' && method.toUpperCase()!='POST') {
                    let in_method   = document.createElement('input');
                    in_method.type  = "hidden";
                    in_method.name  = "_method";
                    in_method.value = method.toUpperCase();
                    form.appendChild(in_method);
                }
                $('body').append(form);
                form.submit();
            }
        });

    });
}

// ! Seleção -| Selectpicker
function load_selectpicker(E){
    $(E).selectpicker({
        container: 'body',
        noneSelectedText : '',
        noneResultsText: 'Nenhum resultado encontrado'
    });
}

// ! Tabela Listar -| DataTable
function load_datatable_st1(E){
    $(E).DataTable({
        'order': [],
        'orderable': true,
        'pageLength': 25
    });
}

// ! Tags -| Seleção
function load_tags_st1(E){
    $(E).each(function(i,e){
        const _this   = $(e);
        if(_this.data('lista')==undefined) { return true; }
        _this[0].tagify = (new Tagify(_this[0], {
            whitelist: _this.data('lista'),
            enforceWhitelist: true,
            dropdown: {
                classname: 'tags-look',
                enabled: 0,
                closeOnSelect: false
            }
        }));
        _this[0].value = _this.attr('data-value');
    });
}

// ! Validar Imagem Input Type -> File -| Accept
function load_input_file_accept_auto_validation(E) {
    E.on('change', function() {

        const _this         = $(this);
        if(_this.val()=='') { return; }

        try {
            const _accepts  = _this.attr('accept').split(',').map(function(ext){ return ext.trim().toLowerCase(); });
            const _file     = _this[0].files[0];
            if(_file.type == '') {
                throw { type:'type_not_allowed', title:'Arquivo Inválido!', message:'Arquivo sem extensão, não é permitido.' };
            }
            const _file_ext = _file.name.toLowerCase().split('.').pop();
            if(_accepts.indexOf('.'+_file_ext) < 0) {
                throw { type:'ext_not_allowed', title:'Arquivo Inválido!', message:'Extensão de arquivo não permitida.' };
            }
        }catch(e){
            Swal.fire({icon: 'error', title: e.title, text: e.message, confirmButtonColor: '#0076ff',});
            _this.val('');
        }

    });
}

// ! Recortar Imagem - Crop
function  load_input_file_crop_image(E) {
    E.on('change', function() {

        const _this             = $(this);
        const _parent           = _this.parent();
        const _crop_min_width   = _this.data('crop-min-width');
        const _crop_min_height  = _this.data('crop-min-height');
        const _crop_aspectRatio = _this.data('crop-ratio');

        _parent.find('.box-crop-image').remove();

        if(_this.val()==''){ return; }

        if(!_parent.find('.box-crop-image').length){
            _parent.append(`
                <div class="box-crop-image">
                    <input type="hidden" class="crop_info" name="`+_this.attr('name')+`_crop_info" value=""/>
                    <div class="ci-crop mb-1" style="display:none; width:100%; max-width:500px; height:100%; max-height:300px;">
                        <img src="#" />
                    </div>
                    <div class="ci-btns d-flex">
                        <button type="button" class="btn btn-sm btn-info-st2 btn_file_crop_recortar"><i class="fa fa-scissors"></i>&nbsp;&nbsp;Recortar</button>
                        <button type="button" class="btn btn-sm btn-danger-st2 ml-50 btn_file_crop_cancelar" style="display:none;"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar Recorte</button>
                    </div>
                </div>
            `);
            _parent.find('.btn_file_crop_recortar').on('click',function(){
                APP.consoleLog('-- Crop Recortar --');
                const _this       = $(this);
                const _parent     = _this.closest('.box-crop-image');
                const _input_file = _parent.parent().find('input.file-crop-image');
                const url_create  = URL.createObjectURL(_input_file[0].files[0]);
                if(_parent.find('.ci-crop img').src!=''){ URL.revokeObjectURL(_parent.find('.ci-crop img').attr('src')); }
                _parent.find('.ci-crop img').attr('src',url_create);
                // ! Cropperjs *
                if(_parent.find('.ci-crop img')[0].cropper != undefined){ _parent.find('.ci-crop img')[0].cropper.destroy(); }
                new Cropper(_parent.find('.ci-crop img')[0], {
                    aspectRatio: _crop_aspectRatio,
                    viewMode: 1,
                    autoCropArea: 0.7,
                    responsive: true,
                    background: true,
                    movable: true,
                    zoomable: true,
                    zoomOnWheel: true,
                    dragMode: 'move',
                    scalable: false,
                    rotatable: false,
                    cropBoxResizable: true,
                    cropBoxMovable: true,
                    guides: true,
                    center: true,
                    highlight: true,
                    minCropBoxWidth: _crop_min_width,
                    minCropBoxHeight: _crop_min_height,
                    crop(event) {
                        _parent.find('.crop_info').val(JSON.stringify(event.detail));
                    }
                });
                // - !
                //_parent.find('.crop_info').val(JSON.stringify(_parent.find('.ci-crop img')[0].cropper.getData(true)));
                _parent.find('.ci-crop').show();
                _parent.find('.btn_file_crop_cancelar').show();
                _parent.find('.btn_file_crop_recortar').hide();
            });
            _parent.find('.btn_file_crop_cancelar').on('click',function(){
                APP.consoleLog('-- Crop Cancelar --');
                const _this       = $(this);
                const _parent     = _this.closest('.box-crop-image');
                const _input_file = _parent.parent().find('input.file-crop-image');
                _parent.find('.crop_info').val('');
                _parent.find('.ci-crop').hide();
                _parent.find('.btn_file_crop_cancelar').hide();
                _parent.find('.btn_file_crop_recortar').show();
            });
        }

    });
}

// ! Input File Remove
function load_input_file_remove(E) {
    E.on('click', function(){
        const _this        = $(this);
        const _parent_box  = _this.closest('.box-preview-file');
        const _parent      = _parent_box.parent();
        _parent.append('<input type="hidden" name="'+_this.data('input-name-remove')+'_remove" value="1" />');
        _parent_box.remove();
    });
}

// ! Input Password - On / Off
function load_btn_input_password(E){
    E.on('click',function(){
        const _this          = $(this);
        const _in_password   = $(_this.data('input-password'));
        const _fa_icon       = _this.find('.fa');
        if(_in_password.attr('type')=='password'){
            _in_password.attr('type','text');
            _fa_icon.removeClass('fa-eye-slash');
            _fa_icon.addClass('fa-eye');
        }else {
            _in_password.attr('type','password');
            _fa_icon.removeClass('fa-eye');
            _fa_icon.addClass('fa-eye-slash');
        }
    });
}

// ! Consultar CEP
function load_btn_consulta_cep(E){
    E.on('click',function(){
        const _this          = $(this);
        const _in_cep        = $(_this.data('input-cep'));
        if(_in_cep.val()==''){ return false; }

        const _in_set_edr_rua       = $(_this.data('input-set-rua'));
        const _in_set_edr_numero    = $(_this.data('input-set-numero'));
        const _in_set_edr_comple    = $(_this.data('input-set-complemento'));
        const _in_set_edr_bairro    = $(_this.data('input-set-bairro'));
        const _in_set_edr_uf        = $(_this.data('input-set-uf'));
        const _in_set_edr_municip   = $(_this.data('input-set-municipio'));

        $.ajax({
            url: G.app_url+'/api/v1/consultas/cep/'+_in_cep.val().replace(/\D/g,''),
            method: 'GET',
            //data: { },
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'json',
            //headers: { },
            xhrFields: { withCredentials: true },
            beforeSend: function() { /* ... */ },
            success: function(data) {
                _in_set_edr_rua.val(data.logradouro?data.logradouro:'');
                _in_set_edr_numero.val(data.numero?data.numero:'');
                _in_set_edr_comple.val(data.complemento?data.complemento:'');
                _in_set_edr_bairro.val(data.bairro?data.bairro:'');
                _in_set_edr_municip.attr('_value',(data.localidade?data.localidade:''))
                _in_set_edr_uf.val(data.uf?data.uf:'').selectpicker('refresh').trigger('change');
            },
            error: function() { /* ... */ },
            complete: function() { /* ... */ }
        });

    });
}

// ! Consultar CNPJ
function load_btn_consulta_cnpj(E){
    E.on('click',function(){
        const _this          = $(this);
        const _in_cnpj       = $(_this.data('input-cnpj'));

        if(_in_cnpj.val()==''){ return false; }

        const _in_event_after       = _this.data('event-after');
        const _in_set_datafundacao  = $(_this.data('input-set-datafundacao'));
        const _in_set_email         = $(_this.data('input-set-email'));
        const _in_set_telefone      = $(_this.data('input-set-telefone'));
        const _in_set_telefone2     = $(_this.data('input-set-telefone2'));
        const _in_set_razaoSocial   = $(_this.data('input-set-razaosocial'));
        const _in_set_fantasia      = $(_this.data('input-set-fantasia'));
        const _in_set_erd_cep       = $(_this.data('input-set-cep'));
        const _in_set_edr_rua       = $(_this.data('input-set-rua'));
        const _in_set_edr_numero    = $(_this.data('input-set-numero'));
        const _in_set_edr_comple    = $(_this.data('input-set-complemento'));
        const _in_set_edr_bairro    = $(_this.data('input-set-bairro'));
        const _in_set_edr_uf        = $(_this.data('input-set-uf'));
        const _in_set_edr_municip   = $(_this.data('input-set-municipio'));

        _in_set_edr_uf.val('');

        $.ajax({
            url: G.app_url+'/api/v1/consultas/cnpj/'+_in_cnpj.val().replace(/\D/g,''),
            method: 'GET',
            //data: { },
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'json',
            //headers: { },
            xhrFields: { withCredentials: true },
            beforeSend: function() { /* ... */ },
            success: function(data) {
                _in_set_datafundacao.val((data.abertura && data.abertura.length==10)?data.abertura:'').datepicker('update');
                _in_set_email.val(data.email?data.email:'');
                _in_set_telefone.val(data.telefone?data.telefone:'').trigger('input');
                _in_set_telefone2.val(data.telefone2?data.telefone2:'').trigger('input');
                _in_set_razaoSocial.val(data.razao_social?data.razao_social:'');
                _in_set_fantasia.val(data.fantasia?data.fantasia:'');
                _in_set_erd_cep.val((data.endereco && data.endereco.cep)?data.endereco.cep:'').trigger('input');
                _in_set_edr_rua.val((data.endereco && data.endereco.logradouro)?data.endereco.logradouro:'');
                _in_set_edr_numero.val((data.endereco && data.endereco.numero)?data.endereco.numero:'');
                _in_set_edr_comple.val((data.endereco && data.endereco.complemento)?data.endereco.complemento:'');
                _in_set_edr_bairro.val((data.endereco && data.endereco.bairro)?data.endereco.bairro:'');
                _in_set_edr_municip.attr('_value',((data.endereco && data.endereco.municipio)?data.endereco.municipio:''))
                _in_set_edr_uf.val((data.endereco && data.endereco.uf)?data.endereco.uf:'').selectpicker('refresh').trigger('change');

                if(_in_event_after!=undefined && _in_event_after!=''){
                    window[_in_event_after](data);
                }
            },
            error: function() { /* ... */ },
            complete: function() { /* ... */ }
        });
    });
}

// ! Estado Municípios
function load_change_uf_municipios(E, TriggerChange = false){
    E.on('change',function(){
        const _this           = $(this);
        const _in_edr_cidades = $(_this.data('input-municipios'));
        if(_this.val()==''){ return false; }

        $.ajax({
            url: G.app_url+'/api/v1/consultas/municipios/'+_this.val(),
            method: 'GET',
            //data: { },
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            dataType: 'json',
            //headers: { },
            xhrFields: { withCredentials: true },
            beforeSend: function() { /* ... */ },
            success: function(data) {
                let html = '<option value="">---</option>';
                $(data).each(function(i,e){
                    html += '<option value="'+e.nome+'">'+e.nome+'</option>';
                });
                _in_edr_cidades.html(html).selectpicker('refresh');
                if(_in_edr_cidades.attr('_value')!='') {
                    // ! Fix*
                    let op_value_caseSens = '';
                    $(_in_edr_cidades.find('option')).each(function(i,e){
                        if($(e).attr('value').toLowerCase() == _in_edr_cidades.attr('_value').toLowerCase()){
                            op_value_caseSens = $(e).attr('value');
                            return;
                        }
                    });
                    // - !
                    _in_edr_cidades.val(op_value_caseSens).selectpicker('refresh');
                }
            },
            error: function() { /* ... */ },
            complete: function() { /* ... */ }
        });
    });

    if(TriggerChange){ E.trigger('change'); }
}

// ! Lista Modelo ** Tabela | <table> **
function load_box_repeat_table(E){
    function verificar_itens(E2){
        const qt_itens = E2.find('tr.repeat-table-item').not('.repeat-table-item-copia,.repeat-table-sem-registro,.repeat-table-item-remover').length;
        if(!qt_itens){
            E2.find('.repeat-table-sem-registro').show();
        }else {
            E2.find('.repeat-table-sem-registro').hide();
        }
    }
    function load_btn_remover(E2){
        E2.on('click', function() {
            const _tr  = $(this).closest('tr');
            const _box = E2.closest('.box-repeat-table');
            _tr.fadeOut(300, function(){
                if(_tr.find('.ae_cnae_secundario_id').val()!=''){
                    _tr.addClass('repeat-table-item-remover');
                    _tr.find('.ae_cnae_secundario_remover').val(1);
                }else {
                    _tr.remove();
                }
                verificar_itens(_box);
            });
        });
    }
    $(E).each(function(i,e){
        const _this         = $(e);
        const tr_copia      = _this.find('tr.repeat-table-item-copia');
        const btns_remover  = _this.find('button.btn-remover').not('[disabled]');
        const btn_adicionar = _this.find('button.btn-adicionar');
        btn_adicionar.on('click', function() {
            let clone = tr_copia.clone();

            clone.removeClass('repeat-table-item-copia');
            clone.find('input,select,textarea,button').prop('disabled', false);

            load_btn_remover(clone.find('button.btn-remover'));

            load_mask_cpf(clone.find('.mask-cpf'));
            load_mask_cnpj(clone.find('.mask-cnpj'));
            load_mask_data(clone.find('.mask-data'));
            load_mask_porcentagem_n1(clone.find('.mask-porcentagem-n1'));
            load_mask_porcentagem_n2(clone.find('.mask-porcentagem-n2'));
            load_data_picker(clone.find('.data-picker'));

            _this.find('tbody').append(clone);
            verificar_itens(_this);
        });
        load_btn_remover(btns_remover);
        verificar_itens(_this);
    });
}

// ! Lista Modelo ** Grid **
function load_box_repeat(E){
    function verificar_itens(E2){
        const qt_itens = E2.find('.repeat-item').not('.repeat-item-copia,.repeat-sem-registro,.repeat-item-remover').length;
        if(!qt_itens){
            E2.find('.repeat-sem-registro').show();
        }else {
            E2.find('.repeat-sem-registro').hide();
        }
    }
    function load_btn_remover(E2){
        E2.on('click', function(){
            const _item = $(this).closest('.repeat-item');
            const _box  = E2.closest('.box-repeat');
            _item.fadeOut(300, function(){
                if(_item.find('.socio_id').val()!=''){
                    _item.addClass('repeat-item-remover');
                    _item.find('.socio_remover').val(1);
                }else {
                    _item.remove();
                }
                verificar_itens(_box);
            });
        });
    }
    $(E).each(function(i,e){
        const _this         = $(e);
        const _copia        = _this.find('.repeat-item-copia');
        const btns_remover  = _this.find('button.btn-remover').not('[disabled]');
        const btn_adicionar = _this.find('button.btn-adicionar');
        btn_adicionar.on('click', function() {
            let clone = _copia.clone();

            clone.removeClass('repeat-item-copia');
            clone.find('input,select,textarea,button').prop('disabled', false);

            load_btn_remover(clone.find('button.btn-remover'));

            load_mask_cpf(clone.find('.mask-cpf'));
            load_mask_cnpj(clone.find('.mask-cnpj'));
            load_mask_data(clone.find('.mask-data'));
            load_mask_porcentagem_n1(clone.find('.mask-porcentagem-n1'));
            load_mask_porcentagem_n2(clone.find('.mask-porcentagem-n2'));
            load_data_picker(clone.find('.data-picker'));

            _this.find('.repeat-body').append(clone);
            verificar_itens(_this);
        });
        load_btn_remover(btns_remover);
        verificar_itens(_this);
    });
}

window.addEventListener('load', function() {
    H.load();
});

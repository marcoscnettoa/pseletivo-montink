@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-box color-st1"></i>&nbsp;&nbsp;Estoques</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <form id="{{!$estoques?'form_estoques_create':'form_estoques_edit'}}" action="{{!$estoques?route('estoques.store'):route('estoques.update',['id'=>$estoques->id])}}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method((!$estoques?'POST':'PUT'))
            <div class="content-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    @if(!$estoques)
                                        <h4 class="card-title">Cadastrar Estoque</h4>
                                    @else
                                        <h4 class="card-title">Editar Estoque</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="in_loja_produtos_id">Produto <span class="color-danger">*</span></label>
                                            @php
                                                $loja_produtos_id_selected = old('loja_produtos_id',($estoques?$estoques->loja_produtos_id:''));
                                            @endphp
                                            <select class="form-control selectpicker-st1" name="loja_produtos_id" data-live-search="true" id="in_loja_produtos_id">
                                                <option value="">---</option>
                                                @foreach(\App\Models\Produtos::getLista(pluck:true,array:true) as $id => $produto)
                                                    <option value="{{$id}}" {{(($loja_produtos_id_selected==$id)?'selected':'')}}>{{$produto}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="in_loja_variacoes_id">Variação <span class="color-danger">*</span></label>
                                            @php
                                                $loja_variacoes_id_selected = old('loja_variacoes_id',($estoques?$estoques->loja_variacoes_id:''));
                                            @endphp
                                            <select class="form-control selectpicker-st1" name="loja_variacoes_id" _value="{{$loja_variacoes_id_selected}}" data-live-search="true" id="in_loja_variacoes_id">
                                                <option value="">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="in_quantidade">Quantidade <span class="color-danger">*</span></label>
                                            <input type="text" name="quantidade" value="{{old('quantidade',$estoques?$estoques->quantidade:'')}}" class="form-control in_quantidade mask-numero-n1" id="in_quantidade" placeholder="0" required maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            @if(!$estoques)
                                                <button type="submit" class="btn btn-sm btn-primary-st2 ml-auto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</button>
                                            @else
                                                <a href="{{route('estoques.index')}}" class="btn btn-sm btn-default-st2 mr-auto"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
                                                <button type="submit" class="btn btn-sm btn-primary-st2 ml-auto"><i class="fa fa-edit"></i>&nbsp;&nbsp;Editar</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $("#in_loja_produtos_id").on('change', function() {
            const _this = $(this);
            const _in_loja_variacoes_id = $("#in_loja_variacoes_id");
            if(_this.val()=='') { return false; }
            $.ajax({
                url: G.app_url + '/api/v1/variacoes/produto/'+ _this.val(),
                method: 'GET',
                data: [],
                dataType: "json",
                beforeSend: function() { /* ... */ },
                success: function(data) {
                    let html = '<option value="">---</option>';
                    $(data).each(function(i,e){
                        html += '<option value="'+e.id+'">'+e.nome+'</option>';
                    });
                    _in_loja_variacoes_id.html(html).selectpicker('refresh');
                    if(_in_loja_variacoes_id.attr('_value')!=''){
                        _in_loja_variacoes_id.val(_in_loja_variacoes_id.attr('_value')).selectpicker('refresh');
                    }
                },
                failure: function () {/* ... */}
            });
        }).trigger('change');
    </script>
@endsection

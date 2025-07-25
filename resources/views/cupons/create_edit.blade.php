@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-award color-st1"></i>&nbsp;&nbsp;Cupons</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <form id="{{!$cupons?'form_cupons_create':'form_cupons_edit'}}" action="{{!$cupons?route('cupons.store'):route('cupons.update',['id'=>$cupons->id])}}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method((!$cupons?'POST':'PUT'))
            <div class="content-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    @if(!$cupons)
                                        <h4 class="card-title">Cadastrar Cupom</h4>
                                    @else
                                        <h4 class="card-title">Editar Cupom</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="in_codigo">Código <span class="color-danger">*</span></label>
                                            <input type="text" name="codigo" value="{{old('codigo',$cupons?$cupons->codigo:'')}}" oninput="$(this).val($(this).val().toUpperCase())" class="form-control in_codigo" id="in_codigo" placeholder="__________" required maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="in_desconto">Desconto <span class="color-danger">*</span></label>
                                            <input type="text" name="desconto" value="{{old('desconto',$cupons?\App\Helpers\Helper::H_Decimal_DB_ptBR($cupons->desconto):'')}}" class="form-control in_desconto mask-dinheiro-br-n1" id="in_desconto" placeholder="0,00" required maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="in_valor_minimo">Valor Mínimo <span class="color-danger">*</span></label>
                                            <input type="text" name="valor_minimo" value="{{old('valor_minimo',$cupons?\App\Helpers\Helper::H_Decimal_DB_ptBR($cupons->valor_minimo):'')}}" class="form-control in_valor_minimo mask-dinheiro-br-n1" id="in_valor_minimo" placeholder="0,00" required maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="in_validade">Data de Validade <span class="color-danger">*</span></label>
                                            <input type="text" name="validade" value="{{old('validade',$cupons?\App\Helpers\Helper::H_Data_DB_ptBR($cupons->validade):'')}}" class="form-control in_validade mask-data data-picker" id="in_validade" placeholder="__/__/____" required maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            @if(!$cupons)
                                                <button type="submit" class="btn btn-sm btn-primary-st2 ml-auto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</button>
                                            @else
                                                <a href="{{route('cupons.index')}}" class="btn btn-sm btn-default-st2 mr-auto"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
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
        /* ... */
    </script>
@endsection

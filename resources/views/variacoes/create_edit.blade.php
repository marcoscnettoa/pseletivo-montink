@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-tag color-st1"></i>&nbsp;&nbsp;Variações</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <form id="{{!$variacoes?'form_variacoes_create':'form_variacoes_edit'}}" action="{{!$variacoes?route('variacoes.store'):route('variacoes.update',['id'=>$variacoes->id])}}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method((!$variacoes?'POST':'PUT'))
            <div class="content-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    @if(!$variacoes)
                                        <h4 class="card-title">Cadastrar Variação</h4>
                                    @else
                                        <h4 class="card-title">Editar Variação</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="in_loja_produtos_id">Produto <span class="color-danger">*</span></label>
                                            @php
                                                $loja_produtos_id_selected = old('loja_produtos_id',($variacoes?$variacoes->loja_produtos_id:''));
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
                                            <label for="in_nome">Nome da Variação <span class="color-danger">*</span></label>
                                            <input type="text" name="nome" value="{{old('nome',$variacoes?$variacoes->nome:'')}}" class="form-control in_nome" id="in_nome" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            @if(!$variacoes)
                                                <button type="submit" class="btn btn-sm btn-primary-st2 ml-auto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</button>
                                            @else
                                                <a href="{{route('variacoes.index')}}" class="btn btn-sm btn-default-st2 mr-auto"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
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

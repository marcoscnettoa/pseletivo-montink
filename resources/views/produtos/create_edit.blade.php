@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-aperture color-st1"></i>&nbsp;&nbsp;Produtos</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <form id="{{!$produtos?'form_produtos_create':'form_produtos_edit'}}" action="{{!$produtos?route('produtos.store'):route('produtos.update',['id'=>$produtos->id])}}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method((!$produtos?'POST':'PUT'))
            <div class="content-body mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-head">
                                <div class="card-header">
                                    @if(!$produtos)
                                        <h4 class="card-title">Cadastrar Produto</h4>
                                    @else
                                        <h4 class="card-title">Editar Produto</h4>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="in_imagem">Imagem do Produto</label>
                                            @php
                                                $imagem = (!empty($produtos->imagem)?URL('/storage').'/'.$produtos->imagem:null);
                                            @endphp
                                            @if(!is_null($imagem) && \App\Helpers\Helper::http_url_head_ok($imagem))
                                                <div class="box-preview-file mb-1">
                                                    <div class="preview-file d-inline-block position-relative pt-1">
                                                        <button type="button" class="btn btn-sm btn-danger-st2 btn-preview-file-remove-input" data-input-name-remove="imagem"><i class="fa fa-remove"></i></button>
                                                        <img class="img-preview" src="{{$imagem}}" width="150" height="auto" alt="Imagem" />
                                                    </div>
                                                </div>
                                            @endif
                                            <input type="file" name="imagem" value="" class="form-control in_imagem file-crop-image" accept="{{\App\Helpers\FileHelper::input_accepts_imagens()}}" id="in_imagem" data-crop-min-width="200" data-crop-min-height="200" data-crop-ratio="1">
                                            <small class="font-italic mb-50"><b>Extensões permitidas:</b> {{\App\Helpers\FileHelper::input_accepts_imagens()}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="box_cnpj">
                                        <div class="form-group">
                                            <label for="in_nome">Nome <span class="color-danger">*</span></label>
                                            <input type="text" name="nome" value="{{old('nome',$produtos?$produtos->nome:'')}}" class="form-control in_nome" id="in_nome" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="box_cnpj">
                                        <div class="form-group">
                                            <label for="in_preco">Preço <span class="color-danger">*</span></label>
                                            <input type="text" name="preco" value="{{old('preco',$produtos?\App\Helpers\Helper::H_Decimal_DB_ptBR($produtos->preco):'')}}" class="form-control in_preco mask-dinheiro-br-n1" id="in_preco" placeholder="0,00" required maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" id="box_cnpj">
                                        <div class="form-group">
                                            <label for="in_descricao">Descrição</label>
                                            <textarea name="descricao" class="form-control in_descricao" id="in_descricao" maxlength="500" rows="6">{{old('descricao',$produtos?$produtos->descricao:'')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            @if(!$produtos)
                                                <button type="submit" class="btn btn-sm btn-primary-st2 ml-auto"><i class="fa fa-plus"></i>&nbsp;&nbsp;Cadastrar</button>
                                            @else
                                                <a href="{{route('produtos.index')}}" class="btn btn-sm btn-default-st2 mr-auto"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancelar</a>
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

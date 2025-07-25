@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-shopping-cart color-st1"></i>&nbsp;&nbsp;Carrinho de Compra</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <div class="content-body mt-2">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-head">
                                <h4 class="card-title"><i class="feather icon-list"></i>&nbsp;&nbsp;Lista</h4>
                            </div>
                            <div class="card-content mt-1">
                                <div class="table-responsive">
                                    <table class="table table-st1 table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Produto</th>
                                                <th class="text-left" width="50">Variação</th>
                                                <th class="text-left" width="50">Quantidade</th>
                                                <th class="text-left" width="50">Preço</th>
                                                <th class="text-center" width="50" data-orderable="false">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($produtos))
                                            @foreach($produtos as $produto)
                                                <tr>
                                                    <td class="text-left" nowrap>
                                                        <div class="d-flex align-items-center">
                                                            <div class="p-imagem mr-2">
                                                                <img src="{{$produto['produto_imagem']}}" width="50" alt="Imagem" />
                                                            </div>
                                                            <div class="p-produto">
                                                                {{$produto['produto_nome']}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center" nowrap>{{$produto['variacao_nome']}}</td>
                                                    <td class="text-center" nowrap>{{$produto['quantidade']}}</td>
                                                    <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($produto['preco'])}}</td>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('loja.remover.carrinho',['loja_produtos_id'=>$produto['loja_produtos_id'],'loja_variacoes_id'=>$produto['loja_variacoes_id']])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center"><small>Nenhum produto selecionado.</small></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        @if(count($produtos))
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                                <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($valor_subtotal)}}</td>
                                            </tr>
                                            @if(!empty($valor_cupom))
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Cupom:</strong></td>
                                                <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($valor_cupom)}} ( - )</td>
                                            </tr>
                                            @endif
                                            @if(!empty($valor_frete) || $frete_gratis)
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Frete:</strong></td>
                                                @if(!$frete_gratis)
                                                    <td class="text-left" nowrap>{{\App\Helpers\Helper::H_Decimal_DB_ptBR($valor_frete)}}</td>
                                                @else
                                                    <td class="text-left" nowrap>GRÁTIS</td>
                                                @endif
                                            </tr>
                                            @endif
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($valor_total)}}</td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                                @if(count($produtos))
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="codigo" value="{{$cupom_codigo}}" class="form-control in_codigo" oninput="$(this).val($(this).val().toUpperCase())" id="in_codigo" placeholder="Cupom" maxlength="10">
                                                    <div class="input-group-append">
                                                        <button id="btn-cupom" type="button" class="btn btn-default-st2"><i class="fa fa-refresh"></i></button>
                                                        @if(!empty($cupom_codigo))
                                                        <button id="btn-cupom-remover" type="button" class="btn btn-danger-st2"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="in_cep" value="" class="form-control in_cep mask-cep" id="in_cep" placeholder="CEP" maxlength="10">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-default-st2"><i class="fa fa-refresh"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>--}}
                                    </div>
                                    <a href="{{route('loja.index')}}" class="btn btn-primary-st2"><i class="feather icon-home"></i>&nbsp;&nbsp;Continuar Comprando</a>
                                @else
                                    <a href="{{route('loja.index')}}" class="btn btn-primary-st2"><i class="feather icon-home"></i>&nbsp;&nbsp;Ir para Loja</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($produtos))
                <div class="col-md-4">
                    <div class="card">
                        <form id="form_finalizar_compra" action="{{route('finalizar.compra')}}" method="POST" enctype="application/x-www-form-urlencoded">
                        @csrf
                        <div class="card-body">
                            <div class="card-head">
                                <h4 class="card-title"><i class="feather icon-user-check"></i>&nbsp;&nbsp;Dados Cliente</h4>
                            </div>
                            <div class="card-content mt-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_nome">Nome Completo <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_nome" value="{{old('cliente_nome')}}" class="form-control in_cliente_nome" id="in_cliente_nome" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_email">E-mail <span class="color-danger">*</span></label>
                                            <input type="email" name="cliente_email" value="{{old('cliente_email')}}" class="form-control in_cliente_email" id="in_cliente_email" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_cep">CEP <span class="color-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="cliente_cep" value="{{old('cliente_cep')}}" class="form-control in_cliente_cep mask-cep" id="in_cliente_cep" placeholder="_____-___" required maxlength="10">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary-st2 btn-consulta-cep"
                                                            data-input-cep="#in_cliente_cep"
                                                            data-input-set-rua="#in_cliente_endereco"
                                                            data-input-set-numero="#in_cliente_numero"
                                                            data-input-set-complemento="#in_cliente_complemento"
                                                            data-input-set-bairro="#in_cliente_bairro"
                                                            data-input-set-uf="#in_cliente_uf"
                                                            data-input-set-municipio="#in_cliente_cidade"
                                                    ><i class="fa fa-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_endereco">Endereço <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_endereco" value="{{old('cliente_endereco')}}" class="form-control in_cliente_endereco" id="in_cliente_endereco" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_complemento">Complemento</label>
                                            <input type="text" name="cliente_complemento" value="{{old('cliente_complemento')}}" class="form-control in_cliente_complemento" id="in_cliente_complemento" placeholder="" maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_numero">Número <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_numero" value="{{old('cliente_numero')}}" class="form-control in_cliente_numero" id="in_cliente_numero" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_bairro">Bairro <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_bairro" value="{{old('cliente_bairro')}}" class="form-control in_cliente_bairro" id="in_cliente_bairro" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    {{--<div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_uf">Estado <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_uf" value="" class="form-control in_cliente_uf" id="in_cliente_uf" placeholder="" required maxlength="255">
                                        </div>
                                    </div>--}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_uf">Estado <span class="color-danger">*</span></label>
                                            @php
                                                //$status_id_selected = old('edr_estado',($contabilidades && $contabilidades->edr_estado?$contabilidades->edr_estado:''));
                                            @endphp
                                            <select class="form-control selectpicker-st1 dropup change-uf-municipios" name="cliente_uf" data-live-search="true" id="in_cliente_uf" data-size="5" data-input-municipios="#in_cliente_cidade">
                                                <option value="">---</option>
                                                @foreach(\App\Support\Lists\Estados::getLista() as $id => $status)
                                                    <option value="{{$id}}" {{old('cliente_uf')==$id?'selected':''}}>{{$id}}- {{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_cliente_cidade">Cidade <span class="color-danger">*</span></label>
                                            @php
                                                //$status_id_selected = old('edr_cidade',($contabilidades && $contabilidades->edr_cidade?$contabilidades->edr_cidade:''));
                                            @endphp
                                            <select class="form-control selectpicker-st1 dropup" name="cliente_cidade" _value="{{old('cliente_cidade')}}" data-live-search="true" id="in_cliente_cidade" data-size="5">
                                                <option value="">---</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Cidade <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_cidade" value="" class="form-control in_cliente_cidade" id="in_cliente_cidade" placeholder="" required maxlength="255">
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <a href="{{route('loja.cancelar.carrinho')}}" class="btn btn-danger-st2 mr-auto"><i class="feather icon-x-circle"></i>&nbsp;&nbsp;Cancelar</a>
                                            <button type="submit" class="btn btn-success-st2 ml-auto"><i class="feather icon-check-circle"></i>&nbsp;&nbsp;Finalizar Compra</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    {{--{{print_r(session()->get('carrinho'))}}
    {{print_r(session()->get('cupom'))}}--}}
@endsection
@section('script')
    <script>
        $("#btn-cupom").on('click',function(){
            const _this      = $(this).val();
            const _in_codigo = $("#in_codigo");
            if(_in_codigo.val()=='') { return false; }
            H.redirect(G.app_url+'/adicionar-cupom','POST','application/x-www-form-urlencoded', {
                'codigo' : _in_codigo.val()
            });
        });

        $("#btn-cupom-remover").on('click',function(){
            H.redirect(G.app_url+'/remover-cupom','POST','application/x-www-form-urlencoded', { });
        });

        $("#in_cliente_cep").on('change', function(){
           const _this = $(this);
           if(_this.val().length == 9) {
               $("#btn-consulta-cep").trigger('click');
           }
        });
    </script>
@endsection

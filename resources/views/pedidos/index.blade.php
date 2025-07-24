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
                                <h4 class="card-title">Lista</h4>
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
                                        @php
                                            $carrinho = session()->get('carrinho',[]);
                                            $cupom    = session()->get('cupom',[]);
                                            $total    = 0;
                                            $subtotal = 0;
                                        @endphp
                                        @if(count($carrinho))
                                            @foreach($carrinho as $produto_variacao)
                                                @php
                                                    $produto = \App\Models\Produtos::find($produto_variacao['loja_produtos_id']);
                                                    if(!$produto) { continue; }
                                                    $variacao = \App\Models\Variacoes::find($produto_variacao['loja_variacoes_id']);
                                                    if(!$variacao) { continue; }
                                                    $subtotal += $produto->preco;
                                                @endphp
                                                <tr>
                                                    <td class="text-left" nowrap>
                                                        @php
                                                            $imagem             = (!empty($produto->imagem)?URL('/storage').'/'.$produto->imagem:URL('/').'/assets/images/default.jpg');
                                                            $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                                        @endphp
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{$imagem}}" width="50" alt="Imagem" />
                                                            </div>
                                                            <div class="">
                                                                {{( $produto->nome ? $produto->nome : '---' )}}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-left" nowrap>{{( $variacao->nome ? $variacao->nome : '---' )}}</td>
                                                    <td class="text-center" nowrap>{{$produto_variacao['quantidade']}}</td>
                                                    <td class="text-left" nowrap>R$ {{( $produto->preco ? \App\Helpers\Helper::H_Decimal_DB_ptBR($produto->preco) : '---' )}}</td>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('loja.remover.carrinho',['loja_produtos_id'=>$produto_variacao['loja_produtos_id'],'loja_variacoes_id'=>$produto_variacao['loja_variacoes_id']])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center"><small>Nenhum produto selecionado.</small></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                        @if(count($carrinho))
                                        <tfoot>
                                            @php
                                                $cupom_valor = '0,00';
                                                if(isset($cupom['desconto']) && isset($cupom['valor_minimo']) && ($subtotal>=$cupom['valor_minimo'])){
                                                    $cupom_valor = ($subtotal - $cupom['desconto']);
                                                }
                                                $total       = $subtotal - (isset($cupom['desconto'])?$cupom['desconto']:0);
                                                $frete       = 'R$ 0,00';
                                                $frete_valor = 0;
                                                //if($subtotal > 52.00 && $subtotal < 166.59){
                                                if($subtotal < 166.59){
                                                    $frete   = 'R$ 15,00';
                                                    $frete_valor = 15;
                                                }elseif($subtotal > 200){
                                                    $frete   = 'GRÁTIS';
                                                }
                                                $total       = $total + $frete_valor;
                                            @endphp
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                                <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($subtotal)}}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Cupom:</strong></td>
                                                <td class="text-left" nowrap>R$ {{isset($cupom['desconto'])?$cupom['desconto']:'0,00'}} ( - )</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Frete:</strong></td>
                                                <td class="text-left" nowrap>{{$frete}}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($total)}}</td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                                @if(count($carrinho))
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="codigo" value="{{isset($cupom['codigo'])?$cupom['codigo']:''}}" class="form-control in_codigo" oninput="$(this).val($(this).val().toUpperCase())" id="in_codigo" placeholder="Cupom" maxlength="10">
                                                    <div class="input-group-append">
                                                        <button id="btn-cupom" type="button" class="btn btn-default-st2"><i class="fa fa-refresh"></i></button>
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
                @if($carrinho)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-head">
                                <h4 class="card-title">Dados Cliente</h4>
                            </div>
                            <div class="card-content mt-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Nome Completo <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_nome" value="" class="form-control in_cliente_nome" id="in_cliente_nome" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="in_nome">CEP <span class="color-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="cliente_cep" value="" class="form-control in_cliente_cep mask-cep" id="in_cliente_cep" placeholder="_____-___" required maxlength="10">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary-st2"><i class="fa fa-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Endereço <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_endereco" value="" class="form-control in_cliente_endereco" id="in_cliente_endereco" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Complemento <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_complemento" value="" class="form-control in_cliente_complemento" id="in_cliente_complemento" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Número <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_numero" value="" class="form-control in_cliente_numero" id="in_cliente_numero" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Estado <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_uf" value="" class="form-control in_cliente_uf" id="in_cliente_uf" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_nome">Cidade <span class="color-danger">*</span></label>
                                            <input type="text" name="cliente_cidade" value="" class="form-control in_cliente_cidade" id="in_cliente_cidade" placeholder="" required maxlength="255">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <a href="{{route('loja.cancelar.carrinho')}}" class="btn btn-danger-st2 mr-auto"><i class="feather icon-x-circle"></i>&nbsp;&nbsp;Cancelar</a>
                                            <a href="#" class="btn btn-success-st2 ml-auto"><i class="feather icon-check-circle"></i>&nbsp;&nbsp;Finalizar Compra</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    {{print_r(session()->get('carrinho'))}}
    {{print_r(session()->get('cupom'))}}
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
    </script>
@endsection

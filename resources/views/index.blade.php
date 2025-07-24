@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-home color-st1"></i>&nbsp;&nbsp;Loja</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <div class="content-body mt-2">
            <section id="box-lista-produtos" class="lista-produtos">
                <div class="row">
                    @if($produtos->count())
                        @foreach($produtos as $produto)
                            @php
                                $imagem             = (!empty($produto->imagem)?URL('/storage').'/'.$produto->imagem:URL('/').'/assets/images/default.jpg');
                                $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                            @endphp
                            <div class="col-md-3 p-item" loja_produtos_id="{{$produto->id}}">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="imagem text-center">
                                            <img src="{{$imagem}}" width="200" alt="Imagem" />
                                        </div>
                                        <div class="informacoes text-center mt-3">
                                            <strong class="valor">R$ {{ \App\Helpers\Helper::H_Decimal_DB_ptBR($produto->preco) }}</strong>
                                        </div>
                                        <div class="variacoes text-center mt-1">
                                            @if($produto->getEstoqueVariacoes->count())
                                                @foreach($produto->getEstoqueVariacoes as $variacao)
                                                    <span class="variacao" loja_estoques_id="{{$variacao->loja_estoques_id}}" loja_variacoes_id="{{$variacao->loja_variacoes_id}}" quantidade="{{$variacao->quantidade}}">{{$variacao->nome}}</span>
                                                @endforeach
                                            @else
                                                <p class="mb-0"><small>- Sem Estoque -</small></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="button" class="btn btn-success-st2 btn-comprar" disabled><i class="feather icon-shopping-cart"></i>&nbsp;&nbsp;Adicionar Carrinho</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#box-lista-produtos .p-item .variacao").each(function(i,e){
            const _this      = $(e);
            const _p_item    = _this.closest('.p-item');
            const _variacoes = _p_item.find('.variacoes');
            _this.on('click', function(){
                if(_this.hasClass('active')) {
                    _this.removeClass('active');
                }else {
                    _variacoes.find('.variacao').removeClass('active');
                    _this.addClass('active');
                }
                if(_variacoes.find('.variacao.active').length){
                    _p_item.find('.btn-comprar').prop('disabled',false);
                }else {
                    _p_item.find('.btn-comprar').prop('disabled',true);
                }
            });
        });

        $(".btn-comprar").on('click', function(){
            const _this      = $(this);
            const _p_item    = _this.closest('.p-item');
            const _variacao  = _p_item.find('.variacao.active');
            if(!_this.prop('disabled')) {
                H.redirect(G.app_url+'/adicionar-carrinho', 'POST', 'application/x-www-form-urlencoded', {
                    'loja_produtos_id'  : _p_item.attr('loja_produtos_id'),
                    'loja_estoques_id'  : _variacao.attr('loja_estoques_id'),
                    'loja_variacoes_id' : _variacao.attr('loja_variacoes_id')
                });
            }
        });
    </script>
@endsection

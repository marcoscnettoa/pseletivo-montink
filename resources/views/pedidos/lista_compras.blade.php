@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="content-header-title mb-0 font-weight-bold"><i class="feather icon-check-circle color-st1"></i>&nbsp;&nbsp;Lista de Compras</h3>
                </div>
            </div>
            @include('partials.alertas')
        </div>
        <div class="content-body mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-head">
                                <h4 class="card-title"><i class="feather icon-shopping-cart"></i>&nbsp;&nbsp;Pedidos Solicitados</h4>
                            </div>
                            <div class="card-content mt-1">
                                <div class="table-responsive">
                                    <table class="table table-st1 table-lista-compras table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="50">N&deg; Pedido</th>
                                                <th class="text-left">Cliente</th>
                                                {{--<th class="text-left">E-mail</th>
                                                <th class="text-left">CEP</th>--}}
                                                <th class="text-left" width="50">Subtotal</th>
                                                <th class="text-left" width="50">Frete</th>
                                                <th class="text-left" width="50">Cupom</th>
                                                <th class="text-left" width="50">Total</th>
                                                <th class="text-center" width="50">Status</th>
                                                <th class="text-center" width="50">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($pedidos->count())
                                            @foreach($pedidos as $pedido)
                                                <tr>
                                                    <td class="text-center codigo_pedido" nowrap><strong>{{str_pad($pedido->id,5,"0",STR_PAD_LEFT)}}</strong></td>
                                                    <td class="text-left" nowrap>{{$pedido->cliente_nome}}</td>
                                                    {{--<td class="text-left" nowrap>{{$pedido->cliente_email}}</td>
                                                    <td class="text-left" nowrap>{{$pedido->cliente_cep}}</td>--}}
                                                    <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->subtotal)}}</td>
                                                    <td class="text-left" nowrap>{{(!empty($pedido->frete)?'R$ '.\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->frete):'GRÁTIS')}}</td>
                                                    <td class="text-left" nowrap>{{(!empty($pedido->cupom)?'R$ '.\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->cupom):'---')}}</td>
                                                    <td class="text-left" nowrap>R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->total)}}</td>
                                                    @php
                                                        $pedido_status = 'badge-default';
                                                        switch($pedido->status){
                                                            case 'EM_ANDAMENTO':
                                                            case 'AGUARDANDO_PAGAMENTO':    $pedido_status = 'badge-warning'; break;
                                                            case 'ENTREGUE':                $pedido_status = 'badge-success'; break;
                                                            case 'CANCELADO':               $pedido_status = 'badge-danger'; break;
                                                        }
                                                    @endphp
                                                    <td class="text-center" nowrap><span class="badge {{$pedido_status}}">{{\App\Support\Lists\StatusPedido::getStatusByKey($pedido->status)}}</span></td>
                                                    <td class="text-center" nowrap>
                                                        <a href="{{route('notificacao.email',['id' => $pedido->id])}}" target="_blank" class="btn btn-sm btn-info-st2" title="Enviar notificação pedido para o cliente."><i class="feather icon-send"></i>&nbsp;&nbsp;E-mail</a>
                                                    </td>
                                                </tr>
                                                @if($pedido->getPedidoProdutos->count())
                                                <tr>
                                                    <td class="p-0_i m-0_i" colspan="4">
                                                        <table class="table table-striped table-bordered table-lista-compras-produtos p-0 m-0">
                                                            <tr>
                                                                <th class="text-left">Produto</th>
                                                                <th class="text-left">Variação</th>
                                                                <th class="text-left">Quantidade</th>
                                                            </tr>
                                                            @foreach($pedido->getPedidoProdutos as $produto)
                                                            <tr>
                                                                @php
                                                                    $imagem             = (($produto->getProduto && !empty($produto->getProduto->imagem))?URL('/storage').'/'.$produto->getProduto->imagem:URL('/').'/assets/images/default.jpg');
                                                                    $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                                                @endphp
                                                                <td nowrap>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="mr-2">
                                                                            <img src="{{$imagem}}" width="50" alt="Imagem" />
                                                                        </div>
                                                                        <div class="">
                                                                            {{( $produto->nome ? $produto->nome : '---' )}}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td width="50" nowrap>{{$produto->getVariacao?$produto->getVariacao->nome:'---'}}</td>
                                                                <td width="50" nowrap>{{$produto->quantidade}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                    </td>

                                                    <td class="bg-white"></td>
                                                    <td class="bg-white"></td>
                                                    <td class="bg-white"></td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center"><small>Nenhum pedido solicitado.</small></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        /* ... */
    </script>
@endsection

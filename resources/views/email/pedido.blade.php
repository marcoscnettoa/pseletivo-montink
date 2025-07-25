<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pedido Realizado</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
<div style="margin:30px;">
<table width="600" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 600px; background-color: #ffffff; border: 1px solid #cccccc; margin:0 auto;">
    <tr>
        <td style="background-color: #000000; background-repeat: no-repeat; background-position: center; height: 80px; text-align:center;">
            <img class="logo-open" width="150" src="{{URL('assets')}}/images/logo_orbicrm_h.png" />
        </td>
    </tr>
    <tr>
        <td style="background-color: #e75e0f; color: #ffffff; letter-spacing:1px; text-align: center; padding: 10px 0; font-size: 18px; font-weight: bold;">
            Pedido Realizado
        </td>
    </tr>
    <tr>
        <td style="background-color: #ffc3a6; color: #b84600; letter-spacing:1px; text-align: center; padding: 10px 0; font-size: 12px; font-weight: bold;">
            Em Andamento
        </td>
    </tr>
    <tr>
        <td style="padding:20px;">
            Olá <strong>{{$pedido->cliente_nome}}</strong>,<br><br>
            Recebemos o seu pedido com sucesso! 🎉<br><br>
            Abaixo você encontra o resumo completo da sua compra. Em breve, você receberá novas atualizações sobre o status da entrega.<br><br>
            Qualquer dúvida, estamos à disposição.
        </td>
    </tr>
    <tr>
        <td style="padding:20px;">
            <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th align="left" style="border-bottom: 2px solid #e75e0f;">Produto</th>
                        <th align="center" style="border-bottom: 2px solid #e75e0f;">Variação</th>
                        <th align="center" style="border-bottom: 2px solid #e75e0f;">Qtd</th>
                        <th align="right" style="border-bottom: 2px solid #e75e0f;">Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pedido->getPedidoProdutos->count())
                        @foreach($pedido->getPedidoProdutos as $produto)
                            <tr style="background-color: #f9f9f9;">
                                <td>
                                    @php
                                        $imagem             = (($produto->getProduto && !empty($produto->getProduto->imagem))?URL('/storage').'/'.$produto->getProduto->imagem:URL('/').'/assets/images/default.jpg');
                                        $imagem             = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);
                                    @endphp
                                    <img src="{{$imagem}}" width="50" alt="Imagem" style="vertical-align: middle; margin-right:5px;" />
                                    <span>{{( !empty($produto->nome) ? $produto->nome : '---' )}}</span>
                                </td>
                                <td align="center">{{$produto->getVariacao->nome}}</td>
                                <td align="center">{{$produto->quantidade}}</td>
                                <td align="right">R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($produto->preco_unitario)}}</td>
                            </tr>
                       @endforeach
                    @endif
                    <tr>
                        <td colspan="3" align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">Subtotal:</td>
                        <td align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->subtotal)}}</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">Frete:</td>
                        <td align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">{{(!empty($pedido->frete)?'R$ '.\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->frete):'GRÁTIS')}}</td>
                    </tr>
                    @if(!empty($pedido->cupom))
                    <tr>
                        <td colspan="3" align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">Cupom:</td>
                        <td align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->cupom)}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3" align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">Total:</td>
                        <td align="right" style="font-weight: bold; border-top: 2px solid #e75e0f; padding-top: 10px;">R$ {{\App\Helpers\Helper::H_Decimal_DB_ptBR($pedido->total)}}</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="background-color: #000000; color: #a4a4a4; text-align: center; padding: 15px; font-size: 12px;">
            © 2025 {{config('app.name')}}. Todos os direitos reservados.
        </td>
    </tr>
</table>
</div>
</body>
</html>

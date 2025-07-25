<?php
// # **** Rascunho ****
// # GET         /xxxxx ....................... index
// # GET         /xxxxx/create ................ create
// # POST        /xxxxx ....................... store
// # GET         /xxxxx/{id} .................. show
// # GET         /xxxxx/{id}/edit ............. edit
// # PUT|PATCH   /xxxxx/{id} .................. update
// # DELETE      /xxxxx/{id} .................. destroy
// # **** | Temporário -------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use Symfony\Component\Mime\Email;
use Illuminate\Support\Facades\Validator;
use App\Models\PedidosProdutos;
use App\Models\Estoques;
use App\Models\Pedidos;
use App\Models\Cupons;

class PedidosCarrinhoDeComprasController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'cliente_nome'                   =>  'required',
            'cliente_email'                  =>  'required',
            'cliente_cep'                    =>  'required',
            'cliente_endereco'               =>  'required',
            //'cliente_complemento'            =>  'required',
            'cliente_numero'                 =>  'required',
            'cliente_bairro'                 =>  'required',
            'cliente_uf'                     =>  'required',
            'cliente_cidade'                 =>  'required',
        ],[
            'cliente_nome.required'          =>  'Campo <b>"Nome Completo"</b> é obrigatório.',
            'cliente_email.required'         =>  'Campo <b>"E-mail"</b> é obrigatório.',
            'cliente_cep.required'           =>  'Campo <b>"CEP"</b> é obrigatório.',
            'cliente_endereco.required'      =>  'Campo <b>"Endereço"</b> é obrigatório.',
            //'cliente_complemento.required'   =>  'Campo <b>"Complemento"</b> é obrigatório.',
            'cliente_numero.required'        =>  'Campo <b>"Número"</b> é obrigatório.',
            'cliente_bairro.required'        =>  'Campo <b>"Bairro"</b> é obrigatório.',
            'cliente_uf.required'            =>  'Campo <b>"UF"</b> é obrigatório.',
            'cliente_cidade.required'        =>  'Campo <b>"Cidade"</b> é obrigatório.'
        ]);

    }

    public function index() {

        try {

            $carrinho            = session()->get('carrinho',[]);
            $cupom               = session()->get('cupom',[]);

            $valor_total         = 0;
            $valor_subtotal      = 0;
            $valor_frete         = 0;
            $valor_cupom         = 0;

            // ! Carrinho - ( Produto + Variação )
            $produtos            = [];
            foreach($carrinho as $key => $produto_variacao){
                $produto                              = \App\Models\Produtos::find($produto_variacao['loja_produtos_id']);
                $variacao                             = \App\Models\Variacoes::find($produto_variacao['loja_variacoes_id']);
                if(!$variacao || !$produto) { continue; }
                $valor_subtotal += ($produto_variacao['quantidade'] * $produto->preco);

                $imagem                               = (!empty($produto->imagem)?URL('/storage').'/'.$produto->imagem:URL('/').'/assets/images/default.jpg');
                $imagem                               = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);

                $produtos[$key]['loja_produtos_id']   = $produto_variacao['loja_produtos_id'];
                $produtos[$key]['loja_variacoes_id']  = $produto_variacao['loja_variacoes_id'];
                $produtos[$key]['produto_imagem']     = $imagem;
                $produtos[$key]['produto_nome']       = (!empty($produto->nome)?$produto->nome:'---');
                $produtos[$key]['variacao_nome']      = (!empty($variacao->nome)?$variacao->nome:'---');
                $produtos[$key]['quantidade']         = $produto_variacao['quantidade'];
                $produtos[$key]['preco']              = ($produto_variacao['quantidade'] * $produto->preco);
            }

            // ! Cupom de Desconto
            if(
                !empty($cupom) &&
                isset($cupom['desconto']) && isset($cupom['valor_minimo']) &&
                ($valor_subtotal >= $cupom['valor_minimo'])
            ){
                $valor_cupom    = $cupom['desconto'];
            }

            $valor_total        = $valor_subtotal - $valor_cupom;

            // ! Frete
            if($valor_subtotal >= 52 && $valor_subtotal <= 166.59){
                $valor_frete    = 15;
            }elseif($valor_subtotal > 200){
                $valor_frete    = 0;
            }else {
                $valor_frete    = 20;
            }

            $valor_total       += $valor_frete;

            $frete_gratis       = ($valor_subtotal>200?true:false);

            // ::: DEBUG
            //echo 'Subtotal: '.$valor_subtotal.PHP_EOL;
            //echo 'Frete: '.$valor_frete.PHP_EOL;
            //echo 'Cupom: '.$valor_cupom.PHP_EOL;
            //echo 'Total: '.$valor_total.PHP_EOL; exit;
            //print_r($produtos); exit;
            // ::: ------

            return view('pedidos.index', [
                'produtos'          =>      $produtos,
                'cupom_codigo'      =>      (isset($cupom['codigo'])?$cupom['codigo']:''),
                'valor_subtotal'    =>      $valor_subtotal,
                'valor_frete'       =>      $valor_frete,
                'valor_cupom'       =>      $valor_cupom,
                'valor_total'       =>      $valor_total,
                'frete_gratis'      =>      $frete_gratis
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

    public function finalizarCompra(){
        try {

            DB::beginTransaction();

            $data                           = request()->all();

            $carrinho                       = session()->get('carrinho', []);
            $cupom                          = session()->get('cupom', []);

            $validator = $this->validator($data);
            if($validator->fails()){
                DB::rollBack();
                return back()->withInput()->with(array('errors' => $validator->errors()), 403);
            }

            // ! Validar -| Carrinho Disponível
            if(empty($carrinho)){
                DB::rollBack();
                return redirect()->route('loja.index')->withErrors(['error' => '<b>Sua sessão expirou!</b> Efetue a compra novamente.']);
            }

            // ! Validar -| Estoque Disponível ( produto + variação )
            $estoque_inexistente = false;
            foreach($carrinho as $key => $produto_variacao){

                $estoque                    = Estoques::where('loja_produtos_id',$produto_variacao['loja_produtos_id'])
                                                         ->where('loja_variacoes_id',$produto_variacao['loja_variacoes_id'])
                                                         ->first();

                if($estoque){
                    // ! Não correspondendo a quantidade ( compra <= estoque )
                    if($produto_variacao['quantidade'] > $estoque->quantidade){
                        DB::rollBack();
                        unset($carrinho[$key]);
                        session()->put('carrinho', $carrinho);
                        return redirect()->route('carrinho.compra')->withInput()->withErrors(['error' => 'Estoque do produto indisponível! Veja a disponibilidade do produto novamente.']);
                    }

                    $estoque->quantidade = ($estoque->quantidade - $produto_variacao['quantidade']);
                    $estoque->save();
                }else {
                    $estoque_inexistente = true;
                    // ! Removendo ( Produto + Variação + Estoque ) inexistente
                    unset($carrinho[$key]);
                }

            }

            session()->put('carrinho', $carrinho);

            if($estoque_inexistente){
                DB::rollBack();
                return redirect()->route('carrinho.compra')->withInput()->withErrors(['error' => 'Finalização de Compra não realizada, produto ficou indisponível. Tente novamente!']);
            }


            // ! Validar -| Cupom
            if(!empty($cupom)){
                $getCupom            = Cupons::where('codigo',$cupom['codigo'])->where('validade','>=',now()->startOfDay())->orderBy('validade','ASC')->first();
                if(!$getCupom){
                    DB::rollBack();
                    session()->forget('cupom');
                    return back()->withInput()->withErrors(['error' => 'Cupom não existe ou não é mais válido.']);
                }
            }

            $valor_total         = 0;
            $valor_subtotal      = 0;
            $valor_frete         = 0;
            $valor_cupom         = 0;
            foreach($carrinho as $key => $produto_variacao){
                $produto                    = \App\Models\Produtos::find($produto_variacao['loja_produtos_id']);
                $valor_subtotal            += ($produto_variacao['quantidade'] * $produto->preco);
            }

            // ! Cupom de Desconto
            if(
                !empty($cupom) &&
                isset($cupom['desconto']) && isset($cupom['valor_minimo']) &&
                ($valor_subtotal >= $cupom['valor_minimo'])
            ){
                $valor_cupom                = $cupom['desconto'];
            }

            $valor_total                    = $valor_subtotal - $valor_cupom;

            // ! Frete
            if($valor_subtotal >= 52 && $valor_subtotal <= 166.59){
                $valor_frete    = 15;
            }elseif($valor_subtotal > 200){
                $valor_frete    = 0;
            }else {
                $valor_frete    = 20;
            }

            $valor_total                   += $valor_frete;

            $pedidos                        = new Pedidos();
            $pedidos->loja_cupons_id        = (isset($getCupom)?$getCupom->id:null);
            $pedidos->cliente_nome          = (!empty($data['cliente_nome'])?$data['cliente_nome']:null);
            $pedidos->cliente_email         = (!empty($data['cliente_email'])?$data['cliente_email']:null);
            $pedidos->cliente_cep           = (!empty($data['cliente_cep'])?$data['cliente_cep']:null);
            $pedidos->cliente_endereco      = (!empty($data['cliente_endereco'])?$data['cliente_endereco']:null);
            $pedidos->cliente_complemento   = (!empty($data['cliente_complemento'])?$data['cliente_complemento']:null);
            $pedidos->cliente_numero        = (!empty($data['cliente_numero'])?$data['cliente_numero']:null);
            $pedidos->cliente_uf            = (!empty($data['cliente_uf'])?$data['cliente_uf']:null);
            $pedidos->cliente_cidade        = (!empty($data['cliente_uf'])?$data['cliente_uf']:null);
            $pedidos->subtotal              = $valor_subtotal;
            $pedidos->frete                 = (!empty($valor_frete)?$valor_frete:null);
            $pedidos->cupom_codigo          = (isset($getCupom)?$getCupom->codigo:null);
            $pedidos->cupom                 = (!empty($valor_cupom)?$valor_cupom:null);
            $pedidos->total                 = $valor_total;
            $pedidos->status                = 'EM_ANDAMENTO';
            $pedidos->save();

            foreach($carrinho as $key => $produto_variacao) {
                $produto                                = \App\Models\Produtos::find($produto_variacao['loja_produtos_id']);
                $pedidosProdutos                        = new PedidosProdutos();
                $pedidosProdutos->loja_pedidos_id       = $pedidos->id;
                $pedidosProdutos->loja_produtos_id      = $produto_variacao['loja_produtos_id'];
                $pedidosProdutos->loja_variacoes_id     = $produto_variacao['loja_variacoes_id'];
                $pedidosProdutos->loja_estoques_id      = $produto_variacao['loja_estoques_id'];
                $pedidosProdutos->quantidade            = $produto_variacao['quantidade'];
                $pedidosProdutos->preco_unitario        = $produto->preco;
                $pedidosProdutos->nome                  = $produto->nome;
                $pedidosProdutos->save();
            }


            DB::commit();

            session()->forget('carrinho');
            session()->forget('cupom');

            return redirect()->route('lista.compras')->with([
                'success' => 'Pedido realizado com sucesso!'
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function listaCompra() {
        try {

            $pedidos = Pedidos::get();

            return view('pedidos.lista_compras',[
                'pedidos' => $pedidos
            ]);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('loja.index')->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function notificacaoEmail($id, $preview = true){
        try {

            $pedido = Pedidos::find($id);
            if(!$pedido){ return '-- pedido não encontrado --'; }

            $html_view = view('email.pedido',[
                'pedido' => $pedido
            ])->render();

            if(!$preview){

                Mail::send('email.pedido', ['pedido'=>$pedido], function($message) use ($pedido){
                    $message->from(config('mailers.from.address','no-reply@pseletivo.com.br'),config('mailers.from.name','PSeletivo'));
                    $message->to('marcoscnettoa@gmail.com'); // :: $pedido->cliente_email
                    $message->subject(config('mailers.from.name','PSeletivo').' - Pedido Nº '.str_pad($pedido->id,5,"0",STR_PAD_LEFT).' -| Em Andamento');
                });

                return true;

            }else {
                return $html_view;
            }

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return false;
        }
    }

    public function webhook(Request $request){
        try {

            $data   = request()->all();

            // ! Valida entrada necessárias
            if(empty($data['loja_pedidos_id']) || empty($data['status'])){
                return response()->json(['error'=>'Número do pedido ou Status não informados'],422);
            }

            $pedidos = Pedidos::find($data['loja_pedidos_id']);
            if(!$pedidos){
                return response()->json(['error'=>'Pedido não encontrado!'],422);
            }

            $lista_status    = \App\Support\Lists\StatusPedido::getListaKey();
            if(!in_array(strtoupper($data['status']),$lista_status)){
                return response()->json(['error'=>'Status informado é inválido!'],422);
            }

            $pedidos->status = $data['status'];
            $pedidos->save();

            return response()->json(['ok'=>'Recebido com sucesso']);

        }catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error'=>'Ocorreu um erro.'],500);
        }
    }
}

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

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\Pedidos;
use App\Models\PedidosProdutos;

class PedidosCarrinhoDeComprasController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'cliente_nome'                   =>  'required',
            'cliente_email'                  =>  'required',
            'cliente_cep'                    =>  'required',
            'cliente_endereco'               =>  'required',
            'cliente_complemento'            =>  'required',
            'cliente_numero'                 =>  'required',
            'cliente_bairro'                 =>  'required',
            'cliente_uf'                     =>  'required',
            'cliente_cidade'                 =>  'required',
        ],[
            'cliente_nome.required'          =>  'Campo <b>"Nome Completo"</b> é obrigatório.',
            'cliente_email.required'         =>  'Campo <b>"E-mail"</b> é obrigatório.',
            'cliente_cep.required'           =>  'Campo <b>"CEP"</b> é obrigatório.',
            'cliente_endereco.required'      =>  'Campo <b>"Endereço"</b> é obrigatório.',
            'cliente_complemento.required'   =>  'Campo <b>"Complemento"</b> é obrigatório.',
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
                $produto         = \App\Models\Produtos::find($produto_variacao['loja_produtos_id']);
                $variacao        = \App\Models\Variacoes::find($produto_variacao['loja_variacoes_id']);
                if(!$variacao || !$produto) { continue; }
                $valor_subtotal += $produto->preco;

                $imagem                         = (!empty($produto->imagem)?URL('/storage').'/'.$produto->imagem:URL('/').'/assets/images/default.jpg');
                $imagem                         = (!\App\Helpers\Helper::http_url_head_ok($imagem)?URL('/').'/assets/images/default.jpg':$imagem);

                $produtos[$key]['loja_produtos_id']   = $produto_variacao['loja_produtos_id'];
                $produtos[$key]['loja_variacoes_id']  = $produto_variacao['loja_variacoes_id'];
                $produtos[$key]['produto_imagem']     = $imagem;
                $produtos[$key]['produto_nome']       = (!empty($produto->nome)?$produto->nome:'---');
                $produtos[$key]['variacao_nome']      = (!empty($variacao->nome)?$variacao->nome:'---');
                $produtos[$key]['quantidade']         = $produto_variacao['quantidade'];
                $produtos[$key]['preco']              = $produto->preco;
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

            $validator = $this->validator($data);
            if($validator->fails()){
                DB::rollBack();
                return back()->withInput()->with(array('errors' => $validator->errors()), 403);
            }

            print_r($data); exit;

            $pedidos                        = new Pedidos();

            //$pedidos->loja_cupons_id       = (!empty($data['loja_cupons_id'])?$data['loja_cupons_id']:null);
            $pedidos->cliente_nome          = (!empty($data['cliente_nome'])?$data['cliente_nome']:null);
            $pedidos->cliente_email         = (!empty($data['cliente_email'])?$data['cliente_email']:null);
            $pedidos->cliente_cep           = (!empty($data['cliente_cep'])?$data['cliente_cep']:null);
            $pedidos->cliente_endereco      = (!empty($data['cliente_endereco'])?$data['cliente_endereco']:null);
            $pedidos->cliente_complemento   = (!empty($data['cliente_complemento'])?$data['cliente_complemento']:null);
            $pedidos->cliente_numero        = (!empty($data['cliente_numero'])?$data['cliente_numero']:null);
            $pedidos->cliente_uf            = (!empty($data['cliente_uf'])?$data['cliente_uf']:null);
            $pedidos->cliente_cidade        = (!empty($data['cliente_uf'])?$data['cliente_uf']:null);
            //$pedidos->subtotal             = (!empty($data['subtotal'])?$data['subtotal']:null);
            //$pedidos->frete                = (!empty($data['frete'])?$data['frete']:null);
            //$pedidos->cupom_nome           = (!empty($data['cupom_nome'])?$data['cupom_nome']:null);
            //$pedidos->cupom                = (!empty($data['cupom'])?$data['cupom']:null);
            //$pedidos->desconto             = (!empty($data['desconto'])?$data['desconto']:null);
            //$pedidos->total                = (!empty($data['total'])?$data['total']:null);
            $pedidos->status                = 'EM_ANDAMENTO';

            // !!!!!!!!!!!!!
            //$pedidos->preco                    = (isset($data['preco'])?\App\Helpers\Helper::H_Decimal_ptBR_DB($data['preco']):null);
            // !!!!!!!!!!!!!

            $pedidos->save();

            //$pedidosProdutos                = new PedidosProdutos();
            //$pedidosProdutos->xxxx          = '';
            //$pedidosProdutos->save();

            DB::commit();

            //return redirect()->route('loja.pedidos')->with([
            return redirect()->route('loja.index')->with([
                'success' => 'Pedido realizado com sucesso!'
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }
}

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

use App\Models\Cupons;
use App\Models\Estoques;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\Produtos;

class LojaController extends Controller
{

    public function index() {

        try {

            $produtos = Produtos::with(['getVariacoes'])->orderBy('id','ASC')->get();

            foreach($produtos as $produto){

            }

            return view('index', [
                'produtos' => $produtos
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }

    }

    public function adicionarCarrinho(){

        try {

            $data               =  request()->all();
            $carrinho           = session()->get('carrinho',[]);
            $produto_variacao   = 'loja_produtos_id_'.$data['loja_produtos_id'].'_loja_variacoes_id_'.$data['loja_variacoes_id'];

            // ! Valida a quantidade ( produto + variação )
            $estoque_qt                    = Estoques::where('loja_produtos_id', $data['loja_produtos_id'])
                                                     ->where('loja_variacoes_id', $data['loja_variacoes_id'])
                                                     ->value('quantidade');

            // ! Verificando estoque disponível
            if(isset($carrinho[$produto_variacao]) && (($carrinho[$produto_variacao]['quantidade'] + 1) > $estoque_qt)) {
                return redirect()->route('loja.index')->withInput()->withErrors(['error' => 'Quantidade não disponível em estoque.']);
            }

            if(isset($carrinho[$produto_variacao])) {
                $carrinho[$produto_variacao]['quantidade']++;
            }else {
                $carrinho[$produto_variacao] = [
                    'loja_estoques_id'  => $data['loja_estoques_id'],
                    'loja_produtos_id'  => $data['loja_produtos_id'],
                    'loja_variacoes_id' => $data['loja_variacoes_id'],
                    'quantidade'        => 1,
                ];
            }

            session()->put('carrinho', $carrinho);

            return redirect()->route('carrinho.compra');

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

    public function removerCarrinho(){

        try {

            $data             = request()->all();

            $carrinho         = session()->get('carrinho',[]);

            $produto_variacao = 'loja_produtos_id_'.$data['loja_produtos_id'].'_loja_variacoes_id_'.$data['loja_variacoes_id'];

            unset($carrinho[$produto_variacao]);

            session()->put('carrinho', $carrinho);

            return redirect()->route('carrinho.compra');

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

    public function cancelarCarrinho(){

        try {

            session()->forget('carrinho');

            return redirect()->route('loja.index');

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

    public function adicionarCupom() {

        try {

            $data             =  request()->all();

            $cupom            = Cupons::where('codigo',$data['codigo'])->where('validade','>=',now()->startOfDay())->orderBy('validade','ASC')->first();
            if($cupom){
                session()->put('cupom', [
                    'codigo'        => $cupom->codigo,
                    'valor_minimo'  => $cupom->valor_minimo,
                    'desconto'      => $cupom->desconto,
                    'validade'      => $cupom->validade,
                ]);
                return redirect()->route('carrinho.compra')->with(['success' => 'Cupom aplicado com sucesso!']);
            }else {
                session()->put('cupom', []);
                return redirect()->route('carrinho.compra')->withErrors(['error' => 'Não foi encontrado o cupom informado!']);
            }

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

    public function removerCupom(){

        try {

            session()->forget('cupom');

            return redirect()->route('carrinho.compra');

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
            return redirect()->route('loja.index')->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }

    }

}

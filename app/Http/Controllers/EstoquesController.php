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

use App\Models\Estoques;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class EstoquesController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'loja_produtos_id'              =>  'required',
            'loja_variacoes_id'             =>  'required',
            'quantidade'                    =>  'required',
        ],[
            'loja_produtos_id.required'     =>  'Campo <b>"Produto"</b> é obrigatório.',
            'loja_variacoes_id.required'    =>  'Campo <b>"Variação"</b> é obrigatório.',
            'quantidade.required'           =>  'Campo <b>"Quantidade"</b> é obrigatório.',
        ]);

    }

    public function index() {
        try {

            $estoques = Estoques::orderBy('loja_produtos_id','ASC')->orderBy('loja_variacoes_id','ASC')->get();

            return view('estoques.index', [
                'estoques' => $estoques
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }
    }

    public function edit_create($id = null) {
        try {

            $estoques     = null;
            if(!empty($id)){
                $estoques = Estoques::find($id);
            }

            return view('estoques.create_edit', [
                'estoques' => $estoques
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }
    }

    public function create() {
        return $this->edit_create();
    }

    public function edit($id) {
        return $this->edit_create($id);
    }

    public function store_update($id = null) {
        try {

            DB::beginTransaction();

            $data                                   = request()->all();

            $validator = $this->validator($data, $id);
            if($validator->fails()){
                DB::rollBack();
                return back()->withInput()->with(array('errors' => $validator->errors()), 403);
            }

            // ! Verifica Produto + Variação
            $estoque_exist                          = Estoques::where('loja_produtos_id',$data['loja_produtos_id'])->where('loja_variacoes_id',$data['loja_variacoes_id']);
            if($id){ $estoque_exist->where('id','!=',$id); }
            if($estoque_exist->exists()){
                DB::rollBack();
                Log::warning('Estoques | store_update | '.($id?'update':'store').' -| Estoque ( Produto + Variação ) já cadastrado!');
                return back()->withInput()->withErrors(['error' => 'Esse estoque de ( Produto + Variação ) já existe.']);
            }
            // -

            $estoques                               = null;
            if(!$id) {
                $estoques                           = new Estoques();
            }else {
                $estoques                           = Estoques::find($id);
            }

            $estoques->loja_produtos_id             = (!empty($data['loja_produtos_id'])?$data['loja_produtos_id']:null);
            $estoques->loja_variacoes_id            = (!empty($data['loja_variacoes_id'])?$data['loja_variacoes_id']:null);
            $estoques->quantidade                   = (!empty($data['quantidade'])?$data['quantidade']:null);

            $estoques->save();

            DB::commit();

            return redirect()->route('estoques.edit',['id'=>$estoques->id])->with([
                'success' => ( $id ? 'Estoque <b>editado</b> com sucesso!' : 'Estoque <b>criado</b> com sucesso!' )
            ]);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function store() {
        return $this->store_update();
    }

    public function update($id) {
        return $this->store_update($id);
    }

    public function destroy($id) {
        try {

            DB::beginTransaction();

            $estoques                             = Estoques::find($id);
            if(!$estoques) {
                DB::rollBack();
                Log::warning('Estoques | destroy -| Estoque não encontrado!');
                return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Estoque não encontrado.']);
            }

            $estoques->delete();

            DB::commit();

            return redirect()->route('estoques.index')->with(['success' => 'Estoque <b>excluído</b> com sucesso!']);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

}

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

use App\Models\Variacoes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class VariacoesController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'loja_produtos_id'      =>  'required',
            'nome'                  =>  'required',
        ],[
            'loja_produtos_id.required'  =>  'Campo <b>"Produto"</b> é obrigatório.',
            'nome.required'              =>  'Campo <b>"Nome"</b> é obrigatório.',
        ]);

    }

    public function index() {
        try {

            $variacoes = Variacoes::orderBy('loja_produtos_id','ASC')->get();

            return view('variacoes.index', [
                'variacoes' => $variacoes
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }
    }

    public function edit_create($id = null) {
        try {

            $variacoes     = null;
            if(!empty($id)){
                $variacoes = Variacoes::find($id);
            }

            return view('variacoes.create_edit', [
                'variacoes' => $variacoes
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

            $variacoes                               = null;
            if(!$id) {
                $variacoes                           = new Variacoes();
            }else {
                $variacoes                           = Variacoes::find($id);
            }


            $variacoes->loja_produtos_id             = (!empty($data['loja_produtos_id'])?$data['loja_produtos_id']:null);
            $variacoes->nome                         = (!empty($data['nome'])?$data['nome']:null);

            $variacoes->save();

            DB::commit();

            return redirect()->route('variacoes.edit',['id'=>$variacoes->id])->with([
                'success' => ( $id ? 'Variação <b>editado</b> com sucesso!' : 'Variação <b>criado</b> com sucesso!' )
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

            $variacoes                             = Variacoes::find($id);
            if(!$variacoes) {
                DB::rollBack();
                Log::warning('Variacoes | destroy -| Variação não encontrada!');
                return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Variação não encontrada.']);
            }

            $variacoes->delete();

            DB::commit();

            return redirect()->route('variacoes.index')->with(['success' => 'Variação <b>excluída</b> com sucesso!']);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

}

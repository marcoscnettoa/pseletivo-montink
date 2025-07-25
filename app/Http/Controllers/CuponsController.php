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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class CuponsController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'codigo'                    =>  'required',
            'desconto'                  =>  'required',
            'valor_minimo'              =>  'required',
            'validade'                  =>  'required',
        ],[
            'codigo.required'           =>  'Campo <b>"Código"</b> é obrigatório.',
            'desconto.required'         =>  'Campo <b>"Desconto"</b> é obrigatório.',
            'valor_minimo.required'     =>  'Campo <b>"Valor Mínimo"</b> é obrigatório.',
            'validade.required'         =>  'Campo <b>"Validade"</b> é obrigatório.',
        ]);

    }

    public function index() {
        try {

            $cupons = Cupons::get();

            return view('cupons.index', [
                'cupons' => $cupons
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }
    }

    public function edit_create($id = null) {
        try {

            $cupons     = null;
            if(!empty($id)){
                $cupons = Cupons::find($id);
            }

            return view('cupons.create_edit', [
                'cupons' => $cupons
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

            $cupons                               = null;
            if(!$id) {
                $cupons                           = new Cupons();
            }else {
                $cupons                           = Cupons::find($id);
            }

            $cupons->codigo                     = (!empty($data['codigo'])?strtoupper($data['codigo']):null);
            $cupons->desconto                   = (isset($data['desconto'])?\App\Helpers\Helper::H_Decimal_ptBR_DB($data['desconto']):null);
            $cupons->valor_minimo               = (isset($data['valor_minimo'])?\App\Helpers\Helper::H_Decimal_ptBR_DB($data['valor_minimo']):null);
            $cupons->validade                   = (!empty($data['validade'])?\App\Helpers\Helper::H_Data_ptBR_DB($data['validade']):null);

            $cupons->save();

            DB::commit();

            return redirect()->route('cupons.edit',['id'=>$cupons->id])->with([
                'success' => ( $id ? 'Cupom <b>editado</b> com sucesso!' : 'Cupom <b>criado</b> com sucesso!' )
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

            $cupons                             = Cupons::find($id);
            if(!$cupons) {
                DB::rollBack();
                Log::warning('Cupons | destroy -| Cupom não encontrado!');
                return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Cupom não encontrado.']);
            }

            $cupons->delete();

            DB::commit();

            return redirect()->route('cupons.index')->with(['success' => 'Cupom <b>excluído</b> com sucesso!']);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

}

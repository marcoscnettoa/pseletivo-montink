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

use App\Models\Produtos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class ProdutosController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            'nome'               =>  'required',
            'preco'              =>  'required',
            'imagem'             =>  ((isset($data['imagem'])&&!empty($data['imagem']))?'required|file|mimes:'.\App\Helpers\FileHelper::input_accepts_imagens(false,false).'|max:'.(\App\Helpers\FileHelper::get_bytes_to_kilobytes(config('system.uploads_files.default'))):'')
        ],[
            'nome.required'      =>  'Campo <b>"Nome"</b> é obrigatório.',
            'preco.required'     =>  'Campo <b>"Preço"</b> é obrigatório.',
            'photo.mimes'        =>  'Arquivo <b>"Imagem"</b> permitidos <b>"'.\App\Helpers\FileHelper::input_accepts_imagens().'"</b>',
            'photo.max'          =>  'Arquivo <b>"Imagem"</b> tamanho máximo permitido <b>'.(\App\Helpers\FileHelper::get_bytes_to_megabytes(config('system.uploads_files.default'))).'MB</b>.',
        ]);

    }

    public function index() {
        try {

            $produtos = Produtos::get();

            return view('produtos.index', [
                'produtos' => $produtos
            ]);

        }catch(\Exception $e){
            Log::error('Error: '.$e->getMessage());
        }
    }

    public function edit_create($id = null) {
        try {

            $produtos     = null;
            if(!empty($id)){
                $produtos = Produtos::find($id);
            }

            return view('produtos.create_edit', [
                'produtos' => $produtos
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

            $produtos                               = null;
            if(!$id) {
                $produtos                           = new Produtos();
            }else {
                $produtos                           = Produtos::find($id);
            }

            // ! File - Image - Crop --------------- ** Imagem ** ---------------
            if(isset($data['imagem_remove']) && $data['imagem_remove']){
                $produtos->imagem                   = null;
            }
            // ! CROP_INFO - Recorte realizado pelo usuário!
            $imagem_crop_info_json = ((isset($data['imagem_crop_info']) && !empty($data['imagem_crop_info']))?json_decode($data['imagem_crop_info'], true):null);
            if(isset($data['imagem'])){
                $imageManager                       = new ImageManager(new GdDriver());
                $image                              = $imageManager->read($data['imagem']->getRealPath());
                if($imagem_crop_info_json!=null && !json_last_error()) {
                    $image->crop($imagem_crop_info_json['width'],$imagem_crop_info_json['height'],$imagem_crop_info_json['x'],$imagem_crop_info_json['y']);
                }
                //$image->resize(150, 150);
                $image->scaleDown(200, 200);
                $imageJPG                           = $image->encode(new JpegEncoder(100));
                $pathStoragePublic                  = 'produtos';
                $imageName                          = Str::random(16).'.jpg';
                $pathImageSave                      = $pathStoragePublic.'/'.$imageName;
                Storage::disk('public')->makeDirectory($pathStoragePublic);
                Storage::disk('public')->put($pathImageSave, $imageJPG);

                $produtos->imagem                   = $pathImageSave;
            }
            // - ! ---------------

            $produtos->nome                         = (!empty($data['nome'])?$data['nome']:null);
            $produtos->preco                        = (isset($data['preco'])?\App\Helpers\Helper::H_Decimal_ptBR_DB($data['preco']):null);
            $produtos->descricao                    = (!empty($data['descricao'])?$data['descricao']:null);

            $produtos->save();

            DB::commit();

            return redirect()->route('produtos.edit',['id'=>$produtos->id])->with([
                'success' => ( $id ? 'Produto <b>editado</b> com sucesso!' : 'Produto <b>criado</b> com sucesso!' )
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

            $produtos                             = Produtos::find($id);
            if(!$produtos) {
                DB::rollBack();
                Log::warning('Produtos | destroy -| Produto não encontrada!');
                return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Produto não encontrado.']);
            }

            $produtos->delete();

            DB::commit();

            return redirect()->route('produtos.index')->with(['success' => 'Produto <b>excluído</b> com sucesso!']);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

}

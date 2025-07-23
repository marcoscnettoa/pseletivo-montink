<?php

namespace App\Http\Controllers;

use App\Models\Administradores;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use App\Models\LogsG;
use App\Models\Roles;
use App\Models\User;

class UsersController extends Controller
{

    const  CONTROLLER = 'Users';
    const  MODEL      = 'User';
    const  HASH       = 'Jwk09aHU';

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            //'name'          =>  'required',
        ],[
            //'name.required'         =>  'Campo <b>"Nome"</b> é obrigatório.',
        ]);

    }

    public function index(){
        try {

            $authUser   = Auth::user();

            $users      = User::get();

            LogsG::registrar([
                'controller'            => self::CONTROLLER,
                'model'                 => self::MODEL,
                'action'                => 'index',
                'title'                 => 'Listou os usuários',
                'users_auth_id'         => $authUser->id,
                'users_auth_roles_id'   => $authUser->roles_id,
            ]);

            return view('usuarios.index',[
                'users' => $users
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function create_edit($hash = null) {
        try {

            $authUser   = Auth::user();

            // ! Editar Perfil
            /*if(request()->routeIs('app.usuarios.editar.perfil') && $authUser->hasRole('administrador')){
                $hash = $authUser->hash;
            }else {
                Log::warning('User | index -| Tentando editar perfil modo ( editarPerfil ) de outro usuário!');
                return redirect()->route('app.dashboard.index');
            }*/
            // - !

            $users      = null;
            if($hash){
                $users  = User::findByHash($hash);
                if(!$users){
                    Log::warning('User | store_update | '.($hash?'update':'store').' -| Usuário não encontrado!');
                    return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Usuário não encontrado.']);
                }
            }

            // ! Caso seja Editar Perfil - Confirma se realmente é do usuário
            if(!is_null($users) && request()->get('editarPerfil') == 1 && $authUser->hash != $users->hash){
                DB::rollBack();
                Log::warning('User | index -| Tentando editar perfil modo ( editarPerfil ) ( _GET ) de outro usuário!');
                return redirect()->route('app.dashboard.index');
            }
            // - !

            LogsG::registrar([
                'controller'            => self::CONTROLLER,
                'model'                 => self::MODEL,
                'action'                => ($hash?'edit':'create'),
                'title'                 => ($hash?'Acessou Edição do usuário':'Acessou Criação do usuário'),
                'users_id_affected'     => ($hash?$users->id:null),
                'users_auth_id'         => $authUser->id,
                'users_auth_roles_id'   => $authUser->roles_id,
            ]);

            return view('usuarios.create_edit',[
                'users' => $users
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function create(){
        return $this->create_edit();
    }

    public function edit($hash){
        return $this->create_edit($hash);
    }

    public function store_update($hash = null, $request){
        try {

            DB::beginTransaction();

            $authUser                               = Auth::user();
            $data                                   = $request->all();

            $validator = $this->validator($data, $hash);
            if($validator->fails()){
                DB::rollBack();
                return back()->withInput()->with(array('errors' => $validator->errors()), 403);
            }

            $user_exists                            = User::query();
            $user_exists->where('login', $data['login']);

            $users                                  = null;
            if($hash){
                $users                              = User::findByHash($hash);
                if(!$users){
                    DB::rollBack();
                    Log::warning('User | store_update | '.($hash?'update':'store').' -| Usuário não encontrado!');
                    return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Usuário não encontrado.']);
                }

                $user_exists->where('id', '!=', $users->id);

                $administradores                    = Administradores::findByUsersId($users->id);
                if(!$administradores){
                    DB::rollBack();
                    Log::warning('User | store_update | '.($hash?'update':'store').' -| Administrador não encontrado!');
                    return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Usuário -| Administrador não encontrado.']);
                }

            }else {
                $users                              = new User();
                $users->save(); // ! Forçando geração Hash, HashFiles -| Photo *
                $users->users_id_created            = $authUser->id;

                $administradores                    = new Administradores();
                $administradores->users_id          = $users->id;
                $administradores->users_id_created  = $authUser->id;
                $administradores->save();
                $users->administradores_id          = $administradores->id;
            }

            if($user_exists->exists()){
                DB::rollBack();
                Log::warning('User | store_update | '.($hash?'update':'store').' -| Acesso Login já cadastrado!');
                return back()->withInput()->withErrors(['error' => '<b>Acesso Login já cadastrado</b>, informe outro acesso.']);
            }

            $object_old = ($users?$users->getOriginal():null);

            $Roles                                  = Roles::findByHash($data['roles_id']);
            if(!$Roles){
                DB::rollBack();
                Log::warning('User | store_update | '.($hash?'update':'store').' -| Perfil de Acesso não encontrado!');
                return back()->withInput()->withErrors(['error' => 'Ocorreu um erro! Perfil de Acesso não encontrado.']);
            }

            // ! File - Image - Crop --------------- ** Foto Perfil ** ---------------
            if(isset($data['photo_remove']) && $data['photo_remove']){
                $users->photo                       = null;
            }
            // ! CROP_INFO - Recorte realizado pelo usuário!
            $photo_crop_info_json = ((isset($data['photo_crop_info']) && !empty($data['photo_crop_info']))?json_decode($data['photo_crop_info'], true):null);
            if(isset($data['photo'])){
                $imageManager                       = new ImageManager(new GdDriver());
                $image                              = $imageManager->read($data['photo']->getRealPath());
                if($photo_crop_info_json!=null && !json_last_error()) {
                    $image->crop($photo_crop_info_json['width'],$photo_crop_info_json['height'],$photo_crop_info_json['x'],$photo_crop_info_json['y']);
                }
                //$image->resize(150, 150);
                $image->scaleDown(150, 150);
                $imageJPG                           = $image->encode(new JpegEncoder(100));
                $pathStoragePublic                  = self::HASH.'/'.$users->hash_files;
                $imageName                          = Str::random(16).'.jpg';
                $pathImageSave                      = $pathStoragePublic.'/'.$imageName;
                Storage::disk('public')->makeDirectory($pathStoragePublic);
                Storage::disk('public')->put($pathImageSave, $imageJPG);

                $users->photo                       = $pathImageSave;
            }
            // - ! ---------------

            $users->roles_id                        = $Roles->id;
            $users->name                            = (isset($data['name'])?$data['name']:null);
            $users->surname                         = (isset($data['surname'])?$data['surname']:null);
            $users->login                           = (isset($data['login'])?$data['login']:null);
            $users->email                           = (isset($data['email'])?$data['email']:null);
            $users->password                        = ((isset($data['password']) && !empty($data['password']))?bcrypt($data['password']):$users->password);
            $users->users_id_updated                = $authUser->id;

            $users->save();
            $administradores->save();

            $users->syncRoles($users->getRole->name); // ! ( laravel/permission ) **

            LogsG::registrar([
                'controller'            => self::CONTROLLER,
                'model'                 => self::MODEL,
                'action'                => ($hash?'update':'store'),
                'title'                 => ($hash?'Editou o usuário':'Criou um usuário'),
                'object_old'            => $object_old,
                'object_new'            => ($users?$users->getAttributes():null),
                'users_id_affected'     => ($users?$users->id:null),
                'users_auth_id'         => $authUser->id,
                'users_auth_roles_id'   => $authUser->roles_id,
            ]);

            DB::commit();

            return redirect()->route('app.usuarios.edit',['hash'=>$users->hash, 'editarPerfil' => (request()->get('editarPerfil')?1:null)])->with([
                'success' => ( $hash ? 'Usuário <b>editado</b> com sucesso!' : 'Usuário <b>criado</b> com sucesso!' )
            ]);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

    public function store(Request $request){
        return $this->store_update(null, $request);
    }

    public function update($hash, Request $request){
        return $this->store_update($hash, $request);
    }

    public function destroy($hash, Request $request){
        try {

            DB::beginTransaction();

            $authUser                   = Auth::user();

            $users                      = User::findByHash($hash);
            if(!$users){
                DB::rollBack();
                Log::warning('User | destroy -| Usuário não encontrado!');
                return back()->withInput()->withErrors(['error' => '<b>Ocorreu um erro!</b> Usuário não encontrado.']);
            }

            $object_old                 = $users->getOriginal();

            //$users->users_id_updated    = $authUser->id;
            $users->users_id_deleted    = $authUser->id;
            $users->login_deleted       = $users->login;
            $users->login               = null;
            $users->save();

            if($users->getAdministrador){
                //$users->getAdministrador->users_id_updated  = $authUser->id;
                $users->getAdministrador->users_id_deleted  = $authUser->id;
                $users->getAdministrador->save();
                $users->getAdministrador->delete();
            }

            $users->delete();

            LogsG::registrar([
                'controller'            => self::CONTROLLER,
                'model'                 => self::MODEL,
                'action'                => 'destroy',
                'title'                 => 'Excluiu o usuário',
                'object_old'            => $object_old,
                'users_id_affected'     => $users->id,
                'users_auth_id'         => $authUser->id,
                'users_auth_roles_id'   => $authUser->roles_id,
            ]);

            DB::commit();

            return redirect()->route('app.usuarios.index')->with(['success' => 'Usuário <b>excluído</b> com sucesso!']);

        }catch(Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->withInput()->withErrors(['error' => __('error.error_exception_n1')]);
        }
    }

}

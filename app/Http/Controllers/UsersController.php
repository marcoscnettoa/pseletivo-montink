<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    protected function validator(array $data, $hash=''){

        return Validator::make($data, [
            //'xxxx'          =>  'required',
        ],[
            //'xxxx.required'         =>  'Campo <b>"xxxx"</b> é obrigatório.',
        ]);

    }

    public function index(){
        /* ... */
    }

    public function create_edit($hash = null) {
        /* ... */
    }

    public function create(){
        /* ... */
    }

    public function edit($hash){
        /* ... */
    }

    public function store_update($hash = null, $request){
        /* ... */
    }

    public function store(Request $request){
        /* ... */
    }

    public function update($hash, Request $request){
        /* ... */
    }

    public function destroy($hash, Request $request){
        /* ... */
    }

}

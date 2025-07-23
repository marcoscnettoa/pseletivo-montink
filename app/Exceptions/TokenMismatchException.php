<?php
// # MXTera -
namespace App\Exceptions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TokenMismatchException {

    public function handle(\Symfony\Component\HttpKernel\Exception\HttpException $exception, Request $request)
    {
        if(Auth::check()) {
            return redirect('/')->withErrors(['error' => 'Sua sessão expirou! Por favor, tente novamente.']);
        }
        return redirect('/')->withErrors(['error' => 'Sua sessão expirou!']);
    }

}

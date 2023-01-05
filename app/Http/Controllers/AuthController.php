<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\StrValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public const IF_AUTH_REDIRECT_TO = 'admin.index';

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'auth']);
    }

    public function login(Request $request)
    {
        if (Auth::user()) {
            return redirect()->route(static::IF_AUTH_REDIRECT_TO);
        }

        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'user_identity' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'password' => $request->input('password'),
        ];

        $userIdentity = trim((string) $request->input('user_identity'));

        $validEmail = filter_var($userIdentity, FILTER_VALIDATE_EMAIL);

        if ($validEmail) {
            $credentials['email'] = $validEmail;
        }

        $validCpf = StrValidation::validateCPF($userIdentity) ? preg_replace('/[^0-9]/is', '', $userIdentity) : \null;

        if ($validCpf) {
            $credentials['cpf'] = $validCpf;
        }

        if (!$validEmail && !$validCpf) {
            return \back()->withErrors([
                'Favor fornecer um e-mail ou CPF válido',
            ]);
        }

        $validator = Validator::make($credentials, [
            'email' => 'required_without:cpf',
            'cpf' => 'required_without:email',
        ], [], [
            'email' => 'E-mail',
            'cpf' => 'CPF',
        ]);

        if ($validator->errors()->count()) {
            return \back()->withErrors($validator->errors());
        }

        if (!Auth::attempt($credentials, $request->boolean('remember', false))) {
            return \back()->withErrors([
                'Credenciais não encontradas',
            ]);
        }


        // $user = User::where('usuario', '=', $user)->orwhere('cpf', '=', $user)->where('senha', '=', $senha)->first();

        // if (@$user->id != null) {
        //     @session_start();
        //     $_SESSION['id_usuario'] = $user->id;
        //     $_SESSION['nome_usuario'] = $user->nome;
        //     $_SESSION['nivel_usuario'] = $user->nivel;
        //     $_SESSION['cpf_usuario'] = $user->cpf;

        //     if ($_SESSION['nivel_usuario'] == 'admin') {
        //         return view('painel-admin.index');
        //     }

        //     if ($_SESSION['nivel_usuario'] == 'cadastro') {
        //         return view('painel-cadastro.index');
        //     }
        // } else {
        //     echo "<script language='javascript'> window.alert('Dados Incorretos!') </script>";
        //     return view('index');
        // }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

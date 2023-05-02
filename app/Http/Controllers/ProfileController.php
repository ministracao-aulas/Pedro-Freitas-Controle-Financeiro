<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $data = $request->only([
            'name',
            'email',
            'password',
            'cpf',
        ]);

        $rules = [
            'name' => 'filled|string|min:5',
            'email' => 'filled|email',
        ];

        if ($data['password'] ?? \null) {
            $rules['password'] = 'filled|string|min:6';

            $data['password'] = Hash::make($data['password']);
        }

        if ($data['cpf'] ?? \null) {
            $rules['cpf'] = 'filled|string|min:11';
        }

        $customAttributes = [
            'name' => __('Name'),
            'email' => __('E-mail'),
            'password' => __('Password'),
            'cpf' => __('CPF'),
        ];

        $validator = Validator::make(
            $data,
            $rules,
            [],
            $customAttributes
        );

        $urlOnError = \App\App\Helpers\URL\URLUtils::mergeQueryString(
            back()->getTargetUrl(),
            ['openModal' => 'ModalPerfil']
        );

        if ($validator->fails()) {
            return redirect($urlOnError)
                ->withErrors($validator)
                ->withInput($request->except('password'))
                ->withFragment('modal');
        }

        $success = $user->update($validator->validated());

        if (!$success) {
            return redirect($urlOnError)
                ->with('error', 'Falha ao atualizar a conta.');
        }

        return redirect(back()->getTargetUrl())
            ->with('success', 'Conta atualizada com sucesso.');
    }
}

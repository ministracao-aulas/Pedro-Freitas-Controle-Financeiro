@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <form
        method="post"
        action="{{ route('login') }}"
    >
        @csrf
        <input
            type="text"
            name="user_identity"
            placeholder="Seu e-mail ou CPF"
            required="required"
        />
        <input
            type="password"
            name="password"
            placeholder="Sua senha"
            required="required"
        />
        <div class="checkbox mb-2">
            <label>
                <input
                    type="checkbox"
                    name="remember"
                    value="true"
                > Lembre-se de mim
            </label>
        </div>
        <button
            type="submit"
            class="btn btn-info btn-block btn-large"
        >Entrar</button>
    </form>
@endsection

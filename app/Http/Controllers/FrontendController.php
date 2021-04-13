<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    /**
     *  Submit the register form.
     *  
     *  @param \Illuminate\Http\Request $request
     *  @return \Illuminate\Http\Response
     */
    public function registerSubmit(Request $request)
    {
        $data = $request->all();
        
        $check = $this->create($data);

        Auth::login($check);

        Session::put('user', $data['email']);

        if ($check) {
            request()->session()->flash('success', 'Registrado com sucesso.');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Houve um erro ao criar a sua conta. Por favor, tente novamente.');
            return back();
        }
    }

    /**
     *  Function to register the user in database.
     * 
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
}

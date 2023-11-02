<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistroLoginController extends Controller
{
    //Iniciar sesión
    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'token' => $token,
                'data' => $user
            ], 200);
        
        } else{
            return response()->json([
                'code' => 401,
                'data' => 'Sin autorización',
                'message' => 'Al parecer no has introducido los campos necesarios para iniciar sesión.'
            ], 400);
        }
    }

    //Registro de usuarios
    public function store(Request $request)
    {
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'password' => 'required',
        ]);

        if ($validacion->fails()) {
            return response()->json([
                'code' => 400,
                'data' => $validacion->messages()
            ], 400);
        }

        $user = $this->create($request->all());

        return response()->json([
            'code' => 200,
            'data' => 'Registro exitoso!'
        ], 200);
    }

    protected function create(array $data)
    {
        return User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'telefono' => $data['telefono'],
            'correo' => $data['correo'],
            'password' => Hash::make($data['password']),
        ]);
    }
}

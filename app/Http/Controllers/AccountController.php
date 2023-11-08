<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
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
            'tipo_usuario' => 'required',
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
            'tipo_usuario' => $data['tipo_usuario'],
        ]);
    }

    // Obtener últimos datos del usuario si tiene sesión en localStorage
    public function getDatosUsuario($id) {
        $usuario = User::find($id);

        if ($usuario) {
            if (isset($plato->foto)) {
                $fotoDecodificada = base64_decode($usuario->foto);
                $usuario->foto = $fotoDecodificada;
            }

            return response()->json([
                'code' => 200,
                'data' => $usuario
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'data' => 'No se encontró el usuario'
            ], 404);
        }
    }

    // Actualizar datos del usuario
    protected function updateDatosUsuario(Request $request, $id) {
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'foto' => 'sometimes',
        ]);

        if ($validacion->fails()) {
            return response()->json([
                'code' => 400,
                'data' => $validacion->messages(),
            ], 400);
        } else {
            $usuario = User::find($id);

            if ($usuario) {

                if ($request->has('foto')) {
                    //Guardar la nueva imagen
                    $fotoUsuario = $request->input('foto');
                    $imagenCodificada = base64_encode(file_get_contents($fotoUsuario));

                    //Actualiza la información del usuario, incluyendo la nueva imagen codificada
                    $usuario->update([
                        'nombre' => $request->input('nombre'),
                        'apellido' => $request->input('apellido'),
                        'telefono' => $request->input('telefono'),
                        'foto' => $imagenCodificada
                    ]);
                } else{
                    //Actualiza la información del usuario, sin incluir la nueva imagen codificada
                    $usuario->update([
                        'nombre' => $request->input('nombre'),
                        'apellido' => $request->input('apellido'),
                        'telefono' => $request->input('telefono'),
                    ]);
                }

                return response()->json([
                    'code' => 200,
                    'data' => $usuario
                ], 200);

            } else {
                return response()->json([
                    'code' => 404,
                    'data' => 'Registro para actualizar no encontrado'
                ], 404);
            }
            
        }
    }
}

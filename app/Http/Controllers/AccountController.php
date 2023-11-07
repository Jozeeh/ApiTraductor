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

    // Actualizar datos del usuario
    protected function updateDatosUsuario(Request $request, $id) {
        $validacion = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'foto' => 'required',
        ]);

        if ($validacion->fails()) {
            return response()->json([
                'code' => 400,
                'data' => $validacion->messages()
            ], 400);
        } else {
            $usuario = User::find($id);

            // Guardar la imagen en el servidor
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nombreArchivo = time() . '.' . $foto->getClientOriginalExtension();
                $ruta = public_path('fotosUsuarios/' . $nombreArchivo);
                $foto->move('fotosUsuarios', $nombreArchivo);

                // Actualizar la ruta de la imagen en la base de datos
                $usuario->foto = $nombreArchivo;
            }

            // Resto de la lógica para actualizar otros campos
            $usuario->nombre = $request->input('nombre');
            $usuario->apellido = $request->input('apellido');
            $usuario->telefono = $request->input('telefono');

            $usuario->save();

            return response()->json([
                'code' => 200,
                'data' => 'Datos actualizados correctamente'
            ], 200);
            
        }
    }
}

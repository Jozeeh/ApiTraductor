<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoritosModel;

class FavoritosController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
                'fkIdUsuario' => 'required',
                'Palabra' => 'required',
            ]);
    
            $favorito = new FavoritosModel;
            $favorito->fkIdUsuario = $request->fkIdUsuario;
            $favorito->Palabra = $request->Palabra;
            $favorito->save();
    
            return response()->json(['message' => 'Palabra favorita guardada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hubo un error al guardar la palabra favorita: ' . $e->getMessage()], 500);
        }
    }

    public function mostrarPalabra(){
        try {
            $favorito = FavoritosModel::all();
            return response()->json($favorito);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hubo un error al mostrar la palabra favorita: ' . $e->getMessage()], 500);
        }
    }
        

    public function eliminarFavorito($id){
        try {
            $favorito = FavoritosModel::find($id);
            
            if (!$favorito) {
                return response()->json(['message' => 'No se encontró el favorito'], 404);
            }
            
            $favorito->delete();
            
            return response()->json(['message' => 'Favorito eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Hubo un error al eliminar el favorito: ' . $e->getMessage()], 500);
        }
    }

}
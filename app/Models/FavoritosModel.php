<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritosModel extends Model
{
    use HasFactory;

    protected $table = 'favoritos';
    protected $primaryKey = 'idFavoritos';
    protected $fillable = ['fkIdUsuario', 'Palabra'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizador extends Model
{
    protected $table = 'organizadores';

    protected $primaryKey = 'id_organizador';

    protected $fillable = [
        'nombre',
        'empresa',
        'telefono',
    ];

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_organizador', 'id_organizador');
    }
}

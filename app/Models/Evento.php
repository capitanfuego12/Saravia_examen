<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $primaryKey = 'id_evento';

    protected $fillable = [
        'id_organizador',
        'nombre',
        'fecha',
        'lugar',
        'presupuesto',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'presupuesto' => 'integer',
        ];
    }

    public function organizador(): BelongsTo
    {
        return $this->belongsTo(Organizador::class, 'id_organizador', 'id_organizador');
    }
}

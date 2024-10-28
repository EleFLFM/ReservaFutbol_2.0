<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = ['fecha', 'hora', 'estado'];

    protected $dates = ['fecha', 'hora'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}

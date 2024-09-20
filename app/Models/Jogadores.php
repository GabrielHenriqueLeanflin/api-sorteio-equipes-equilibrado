<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jogadores extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'level',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}

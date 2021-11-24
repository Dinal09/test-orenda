<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoliItems extends Model
{
    use HasFactory;

    protected $table = 'koli_items';
    protected $fillable = [
        'id_user', 'name', 'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_user');
    }
}

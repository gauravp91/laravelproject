<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';
    protected $fillable = [
        'code', 'continent', 'name'
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}

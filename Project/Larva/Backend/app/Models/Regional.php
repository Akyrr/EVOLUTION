<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    protected $table = 'regionals';
    public $timestamps = false;
    
    protected $fillable = [
        'province',
        'district'
    ];
    
    // Relationship dengan Society
    public function societies()
    {
        return $this->hasMany(Society::class);
    }
}
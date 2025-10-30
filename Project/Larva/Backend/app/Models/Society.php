<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Society extends Authenticatable
{
    use HasApiTokens;
    
    protected $table = 'societies';
    
    protected $fillable = [
        'id_card_number',
        'password',
        'name',
        'born_date',
        'gender',
        'address',
        'regional_id'
    ];
    
    protected $hidden = [
        'password'
    ];
    
    // Relationship dengan Regional
    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }
    
    // Relationship dengan Validation
    public function validation()
    {
        return $this->hasOne(Validation::class);
    }
    
    // Relationship dengan Applications
    public function applications()
    {
        return $this->hasMany(InstallmentApplySociety::class);
    }
}
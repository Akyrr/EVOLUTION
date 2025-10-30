<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installment';
    public $timestamps = false;
    
    protected $fillable = [
        'brand_id',
        'cars',
        'description',
        'price'
    ];
    
    // Relationship dengan Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    // Relationship dengan Available Months
    public function availableMonths()
    {
        return $this->hasMany(AvailableMonth::class);
    }
    
    // Relationship dengan Applications
    public function applications()
    {
        return $this->hasMany(InstallmentApplySociety::class);
    }
}

class Brand extends Model
{
    protected $table = 'brand';
    public $timestamps = false;
    
    protected $fillable = ['brand'];
    
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}

class AvailableMonth extends Model
{
    protected $table = 'available_month';
    public $timestamps = false;
    
    protected $fillable = [
        'installment_id',
        'month',
        'description',
        'nominal'
    ];
    
    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
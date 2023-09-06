<?php

namespace App\Models;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
        'image',
        'description',
        'price',
        'quantity',
        'supplier_id',
        'status',
    ];

    protected $appends = [
        'image_url',
    ];

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}

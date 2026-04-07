<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand_id', 'model', 'ean', 'category_id', 'attributes'];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function priceHistory()
    {
        return $this->hasMany(PriceHistory::class);
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'offers');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportLog extends Model
{
    protected $table = 'import_log';

    use HasFactory;

    protected $fillable = ['shop_id', 'file_type', 'imported_at'];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function errors()
    {
        return $this->hasMany(ImportError::class);
    }

}

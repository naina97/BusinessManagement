<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'branches';
    protected $fillable = [
        'name',
        'business_id',
        'images',
        'schedule',
        'exceptions',
    ];

    protected $casts = [
        'schedule' => 'array',
        'exceptions' => 'array',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    

}
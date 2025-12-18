<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'institute',
        'year',
        'grade',
    ];

    public function users():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

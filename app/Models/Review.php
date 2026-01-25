<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
   protected $fillable = [
        'client_name',
        'content',
        'sentiment',
        'score',
        'topics'
    ];

    protected $casts = [
        'topics' => 'array'
    ]; //
}

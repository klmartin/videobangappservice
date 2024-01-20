<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'post_id',
        'uid',
        'path',
        'processed_file',
        'visibility',
        'allow_like',
        'allow_comment',
        'processing_percentage',
    ];
}
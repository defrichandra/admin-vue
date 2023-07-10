<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'thumbnail',
        'title',
        'content',
        'publish_status',
        'publish_date',
    ];
}

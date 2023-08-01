<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Posts extends Model implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'file',
        'thumbnail',
        'title',
        'content',
        'publish_status',
        'publish_date',
        'created_by',
        'updated_by'
    ];

    // Implement the methods required by the JWTSubject interface
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
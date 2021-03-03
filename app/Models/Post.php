<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'content',
        'user_id',
        'file_name',
    ];

    public function user() 
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }


    public function comments()
    {
        return $this->hasMany('App\Models\Comment','post_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tag'); 
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'body',
        'user_id',
        'gallery_id',
    ];


    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }




}

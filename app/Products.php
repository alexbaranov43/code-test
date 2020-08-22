<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
   protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image'
    ];

    public function users()
    {
        return $this->belongsTo('App\User');
    }
}

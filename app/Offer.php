<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offer';

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    public function users(){
        return  $this->belongsToMany(User::class, 'offer_user')->withPivot('code', 'activate');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $timestamps = false;

    protected $table = 'offer';

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    public function users()
    {
        return $this->hasMany(OfferUser::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferUser extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'offer_id',
        'user_id',
        'code',
        'activate'
    ];

    protected $table = "offer_user";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}

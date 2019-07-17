<?php

namespace Tests\Unit;

use App\Offer;
use App\OfferUser;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->createApplication();

        Artisan::call('migrate:reset');

        Artisan::call('migrate');

        Artisan::call('db:seed');
    }


    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    public function test_error_when_save_same_code()
    {
        $this->expectException(QueryException::class );
        $user = factory(User::class)->make();
        $user->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

        $offerUser_1 = new OfferUser([
            'user_id' => $user->id,
            'offer_id' => $offer->id,
            'code' => "12345AH",
            'activate' => false
        ]);

        $offerUser_2 = new OfferUser([
            'user_id' => $user->id,
            'offer_id' => $offer->id,
            'code' => "12345AH",
            'activate' => false
        ]);

        $offerUser_1->save();
        $offerUser_2->save();
    }
}

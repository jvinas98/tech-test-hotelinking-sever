<?php

namespace Tests\Unit;

use App\Offer;
use App\OfferUser;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OfferUserControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function test_insert_1000_registers_no_throw_exception()
    {
        $user = factory(User::class)->make();
        $user->save();

        $offer = factory(Offer::class)->make();
        $offer->save();


        for ($i = 1; $i <= 1000; $i++) {
            $this->json('POST', '/api/user/offer', [
                'idUser' => $user->id,
                'idOffer' => $offer->id,
            ]);
        }

        $this->assertTrue(true);
    }

    public function test_insert_1000_registers_no_throw_exceptions()
    {
        $user = factory(User::class)->make();
        $user->save();
        $this->json('GET', '/api/user/' . $user->id . '/offers')->assertStatus(200)->assertJsonCount(0);
    }

    public function test_get_Offer_User_of_User()
    {
        $user = factory(User::class)->make();
        $user->save();

        $offer = factory(Offer::class)->make();
        $offer->save();

        $offerUser = new OfferUser([
            'user_id' => $user->id,
            'offer_id' => $offer->id,
            'code' => "1234567",
            'activate' => false
        ]);

        $offerUser->save();

        $this->json('GET', '/api/user/' . $user->id . '/offers')->assertStatus(200)->assertJsonCount(1);
    }

    public function test_check_activate_offer()
    {
        $offerUser = factory(OfferUser::class)->make();
        $offerUser->save();

        $this->json('PUT', '/api/user/offer/activate', [
            'id_offer_user' => OfferUser::all()[0]->id
        ]);

        $offerUserOfDatabase = OfferUser::all()[0];

        $this->assertEquals(1, $offerUserOfDatabase->activate);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->createApplication();

        Artisan::call('migrate:reset');

        Artisan::call('migrate');

    }


    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}

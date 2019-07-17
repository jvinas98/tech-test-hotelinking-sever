<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CoreTest extends TestCase
{
    use WithoutMiddleware;

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

    /**
     * Checks the normal flow of a user
     *
     * @return void
     * */
    public function test_core()
    {
        $user = factory(User::class)->make();
        $user->save();

        $offerResponse = $this->json('GET', '/api/offers');
        $offerResponse->assertStatus(200);
        $offers = json_decode($offerResponse->getContent());

        $createOfferOfUserResponse = $this->json('POST', '/api/user/offer', [
            "idUser" => $user->id,
            "idOffer" => $offers[0]->id
        ]);

        $createOfferOfUserResponse->assertStatus(200);
        $code = json_decode($createOfferOfUserResponse->getContent());


        $offersOfUserResponse = $this->json('GET', '/api/user/' . $user->id . '/offers');

        $offersOfUser = json_decode($offersOfUserResponse->getContent());
        $this->assertEquals($code, $offersOfUser[0]->code);

        $activateOfferUserResponse = $this->json('PUT', '/api/user/offer/activate', [
            "id_offer_user" => $offersOfUser[0]->id
        ]);

        $activateOfferUserResponse->assertStatus(200);

        $checkActivateOfferUserResponse = $this->json('GET', '/api/user/' . $user->id . '/offers');

        $checkActivateOffersOfUser = json_decode($checkActivateOfferUserResponse->getContent());
        $this->assertEquals(1, $checkActivateOffersOfUser[0]->activate);

    }
}

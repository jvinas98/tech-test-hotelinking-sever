<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OfferControllerTest extends TestCase
{
    use WithoutMiddleware;

    use WithoutMiddleware;

    public function test_can_show_offers()
    {
        $response = $this->json('GET', '/api/offers');
        $response
            ->assertStatus(200);
    }

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
}

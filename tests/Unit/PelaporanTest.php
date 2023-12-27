<?php

namespace Tests\Unit;

use Tests\TestCase;

class PelaporanTest extends TestCase
{
    /** @test */
    public function TestIndex(){
        $response = $this->json('GET', "api/pelaporan",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
}

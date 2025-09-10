<?php

namespace Tests\Unit;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class FileControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    
    /** @test */
    public function testshow1()
    {
        $response = $this->json('GET', "api/file/g/t",[
        ]);
        // Assert the response status code
        $response->assertStatus(400);
    }
    /** @test */
    public function testshow2()
    {
        $file='VHRj8oo6NAC9t0wGr5mCiA5xuQJEYLP0RgXsGNYs.jpg';
        $response = $this->json('GET', "api/file/$file/test");
        // Assert the response status code
        $response->assertStatus(400);
    }

    
    /** @test */
    public function testshow3()
    {
        $file='WCy5G7DHf76Znhr9bEtkApXuxSHumQn6GxIUYGSs.jpg';
        $response = $this->json('GET', "api/file/$file/foto");
        // Assert the response status code
        $response->assertStatus(404);
    }
    /** @test */
    public function testshow4()
    {
        $file='VHRj8oo6NAC9t0wGr5mCiA5xuQJEYLP0RgXsGNYs.jpg';
        $response = $this->json('GET', "api/file/$file/foto");
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testUpdate(){
        $file = '';
        $response = $this->json('POST', "api/file/20",[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
    /** 
     * @test
     */
    public function testUpdate2(){
        // Create a fake image file for testing
        $file = UploadedFile::fake()->image('new_image.jpg');
        // Assuming 'api/edukasi/{param}' is the correct endpoint for updating
        $param = 16; // Replace with the actual ID of the edukasi you want to update
        // Make a request to the update endpoint with the new image file
        $response = $this->json('POST', "api/file/{$param}", [
            'foto' => $file,
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
}

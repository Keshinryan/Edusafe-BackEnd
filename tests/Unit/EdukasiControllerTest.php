<?php

namespace Tests\Unit;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EdukasiControllerTest extends TestCase
{   
    /** @test */
    public function testshow()
    {
        $response = $this->json('GET', 'api/edukasi',[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testStoreValidationRules1()
    {   
        $response = $this->json('POST', 'api/edukasi', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreValidationRules2()
    {
        
        // Test case when 'foto' field is not a valid file
        $response = $this->json('POST', 'api/edukasi',[
            'judul' => 'Test Judul',
            'isi' => 'Test Isi',
            'foto' => 'not_a_file',
        ]);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreFileUpload()
    {

        // Create a fake image file for testing
        $file = UploadedFile::fake()->image('test.jpg');

        // Create form data with file upload
        $response = $this->json('POST', 'api/edukasi',[
            'judul' => 'Test Judul',
            'isi' => 'Test Isi',
            'foto' => $file,
        ]);
        // Assert the response status code
        $response->assertStatus(201);
    }
    /** @test */
    public function testUpdateValidationRules1()
    {   
        $response = $this->json('PUT', 'api/edukasi/32', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testUpdateValidationRules2()
    {
        
        // Test case when 'foto' field is not a valid file
        $response = $this->json('PUT', 'api/edukasi/32',[
            'judul' => 'Test Judul 2',
            'isi' => 'Test Isi 2',
            'foto' => 'not_a_file',
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function testUpdateFileUploadAndDatabaseInteraction()
    {

        // Create a fake image file for testing
        $file = UploadedFile::fake()->image('testUpdate.jpg');

        // Create form data with file upload
        $response = $this->json('PUT', 'api/edukasi/32',[
            'judul' => 'Test Judul',
            'isi' => 'Test Isi',
            'foto' => $file,
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testshowbyid()
    {
        $response = $this->json('GET', 'api/edukasi/8',[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testshowbyid2()
    {
        $response = $this->json('GET', 'api/edukasi/7',[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
    
    /** @test */
    public function testDeleteData()
    {
        $response = $this->json('DELETE', 'api/edukasi/31',[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testDeleteData2()
    {
        $response = $this->json('DELETE', 'api/edukasi/30',[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
}


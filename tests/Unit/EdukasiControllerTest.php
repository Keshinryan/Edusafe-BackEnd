<?php

namespace Tests\Unit;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EdukasiControllerTest extends TestCase
{
    protected $id;
    private $login;
    /** @test */
    public function testshow()
    {
        $response = $this->json('GET', 'api/edukasi', [
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
        $response = $this->json('POST', 'api/edukasi', [
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
        $response = $this->json('POST', 'api/edukasi', [
            'judul' => 'Test Judul',
            'isi' => 'Test Isi',
            'foto' => $file,
        ]);
        // Assert the response status code
        $response->assertStatus(201);
        $data = $response->json();

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('id', $data['data']);

        $this->id = $data['data']['id'];
        return $this->id;
    }
    /** @test */
    public function testUpdateValidationRules1()
    {
        $response = $this->json('PUT', 'api/edukasi/16', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testUpdateValidationRules2()
    {

        // Test case when 'foto' field is not a valid file
        $response = $this->json('PUT', 'api/edukasi/16', [
            'judul' => 'Test Judul 2',
            'isi' => 'Test Isi 2',
            'foto' => 'not_a_file',
        ]);
        $response->assertStatus(200);
    }

    /** 
     * @test
     * @depends testStoreFileUpload
     */
    public function testUpdateFileUploadAndDatabaseInteraction($id)
    {

        // Create a fake image file for testing
        $file = UploadedFile::fake()->image('testUpdate.jpg');

        // Create form data with file upload
        $response = $this->json('PUT', "api/edukasi/$id", [
            'judul' => 'Test Judul',
            'isi' => 'Test Isi',
            'foto' => $file,
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** 
     * @test
     * @depends testStoreFileUpload
     */
    public function testshowbyid($id)
    {
        $response = $this->json('GET', "api/edukasi/$id", [
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testshowbyid2()
    {
        $response = $this->json('GET', 'api/edukasi/1', [
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }

    /** 
     * @test
     * @depends testStoreFileUpload
     */
    public function testDeleteData($id)
    {
        $response = $this->json('DELETE', "api/edukasi/$id", [
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testDeleteData2()
    {
        $response = $this->json('DELETE', 'api/edukasi/1', [
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
}


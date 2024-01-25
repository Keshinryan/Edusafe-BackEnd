<?php

namespace Tests\Unit;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
class PelaporanControllerTest extends TestCase
{   
    protected $id;
    /**
     * A basic unit test example.
     */
    /** @test */
    public function Testshow1(){
        $response = $this->json('GET', "api/pelaporan",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    
    /** @test */
    public function testStoreValidationRules1()
    {   
        $response = $this->json('POST', 'api/pelaporan', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreValidationRules2()
    {
        
        // Test case when 'foto' field is not a valid file
        $response = $this->json('POST', 'api/pelaporan',[
            'tanggal' => '2023-12-25',
            'waktu' => '07:12:00',
            'tempat' => 'TKP',
            'deskripsi' => 'Isi Deskripsi',
            'bukti' => 'Not A file',
        ]);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreFileUpload()
    {
         // Extract the 'id' value from the response
        // Create a fake image file for testing
        $file = UploadedFile::fake()->image('test.jpg');
        // Create form data with file upload
        $response = $this->json('POST', 'api/pelaporan',[
            'tanggal' => date('Y-m-d',strtotime('2023-12-25')),
            'waktu' => date('H:i:s',strtotime('07:12:00')),
            'tempat' => 'TKP',
            'deskripsi' => 'Isi Deskripsi',
            'bukti' => $file,
            'id_m'=>18,
        ]);
        // Assert the response status code
        $response->assertStatus(201);
        $data = $response->json();

        // Access the 'mahasiswa' array and then get the 'id'
        $this->id = $data['pelaporan']['id'];
        return $this->id;
    }
    public function testUpdateValidationRules()
    {
        $response = $this->json('PUT', 'api/pelaporan/19',[]);
        // Assert the response status code
        $response->assertStatus(400);
    }

    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testUpdateFileUploadAndDatabaseInteraction($id)
    {
        $response = $this->json('PUT', "api/pelaporan/$id",[]);
        // Assert the response status code
        $response->assertStatus(400);
    }
}

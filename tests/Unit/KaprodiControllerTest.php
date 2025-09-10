<?php

namespace Tests\Unit;
use Tests\TestCase;


class KaprodiControllerTest extends TestCase
{   
    protected $id;
    /** @test */
    public function testshow()
    {
        $response = $this->json('GET', 'api/kaprodi',[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testStoreValidationRules1()
    {   
        $response = $this->json('POST', 'api/kaprodi', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreValidationRules2()
    {
        $response = $this->json('POST', 'api/kaprodi',[
            'name_k' => 'Kaprodi',
            'password'=>'123',
            'role'=>'kaprodi',
            'nip' => '12313131',
            'prodi' => 'Teknik Informatika',
            'NOHP' => '0192031938',
        ]);
        $response->assertStatus(201);
        $data = $response->json();
        // Access the 'mahasiswa' array and then get the 'id'
        $this->id = $data['kaprodi']['id'];
        return $this->id;
    }
    /** @test */
    public function testUpdateValidationRules1()
    {   
        $response = $this->json('PUT', 'api/kaprodi/2', []);
        $response->assertStatus(404);
    }/** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testUpdateValidationRules2($id)
    {   
        $response = $this->json('PUT', "api/kaprodi/$id", []);
        $response->assertStatus(400);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testUpdateValidationRules3($id)
    {
        
        // Test case when 'foto' field is not a valid file
        $response = $this->json('PUT', "api/kaprodi/$id",[
            'name_k' => 'Kaprodi2',
            'role'=>'kaprodi',
            'nip' => '2342562',
            'prodi' => 'Teknik Informatika',
            'NOHP' => '1231456',
        ]);
        $response->assertStatus(200);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testshowbyid($id)
    {
        $response = $this->json('GET', "api/kaprodi/$id",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testshowbyid2()
    {
        $response = $this->json('GET', 'api/kaprodi/3',[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testDeleteData($id)
    {
        $response = $this->json('DELETE', "api/kaprodi/$id",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testDeleteData2()
    {
        $response = $this->json('DELETE', 'api/kaprodi/2',[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
}

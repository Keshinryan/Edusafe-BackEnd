<?php

namespace Tests\Unit;
use Tests\TestCase;


class MahasiswaControllerTest extends TestCase
{
    protected $id;
    /** @test */
    public function testshow()
    {
        
        $response = $this->json('GET', 'api/mahasiswa',[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testStoreValidationRules1()
    {   
        $response = $this->json('POST', 'api/mahasiswa', []);
        $response->assertStatus(400);
    }
    /** @test */
    public function testStoreValidationRules2()
    {   
        parent::setUp();
        $response = $this->json('POST', 'api/mahasiswa',[
            'name_m' => 'Dennis',
            'role'=>'mahasiswa',
            'nim' => '12313131',
            'prodi' => 'Teknik Informatika',
            'alamat' => 'Jl....... Gg..........',
            'NOHP' => '0192031938',
        ]);
        $response->assertStatus(201);
        $data = $response->json();

        // Access the 'mahasiswa' array and then get the 'id'
        $this->id = $data['mahasiswa']['id'];
        return $this->id;
    }
    /** @test */
    public function testUpdateValidationRules1()
    {   
        $response = $this->json('PUT', 'api/mahasiswa/32', []);
        $response->assertStatus(404);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testUpdateValidationRules2($id)
    {   
        $response = $this->json('PUT', "api/mahasiswa/$id", []);
        $response->assertStatus(400);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testUpdateValidationRules3($id)
    {
        // Test case when 'foto' field is not a valid file
        $response = $this->json('PUT', "api/mahasiswa/$id",[
            'name_m' => 'JasonP',
            'password' => '1234',
            'nim' => '132145151',
            'prodi' => 'Teknik Informatika',
            'alamat' => 'Jl....... Gg.........',
            'NOHP' => '0899392934',
        ]);
        $response->assertStatus(200);
    }
    /** 
     * @test
     * @depends testStoreValidationRules2
     */
    public function testshowbyid($id)
    {
        $response = $this->json('GET', "api/mahasiswa/$id",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testshowbyid2()
    {
        $response = $this->json('GET', 'api/mahasiswa/7',[
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
        $response = $this->json('DELETE', "api/mahasiswa/$id",[
        ]);
        // Assert the response status code
        $response->assertStatus(200);
    }
    /** @test */
    public function testDeleteData2()
    {
        $response = $this->json('DELETE', 'api/mahasiswa/30',[
        ]);
        // Assert the response status code
        $response->assertStatus(404);
    }
}

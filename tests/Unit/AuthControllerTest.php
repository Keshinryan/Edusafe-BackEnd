<?php

namespace Tests\Unit;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{   
        protected $login;
        /** @test */
        public function testRegister1()
        {
            $response = $this->json('POST', 'api/register',[
            ]);
            // Assert the response status code
            $response->assertStatus(400);
        }
       /** @test */
       public function testRegister2()
       {
           $response = $this->json('POST', 'api/register',[
            'name' => 'Jason',
            'role'=>'mahasiswa',
            'password' => '123',
            'name_m' => 'Jason',
            'nim' => '215131231',
            'prodi' => 'Teknik Informatika',
            'alamat' => 'Jl........ Gg...........',
            'NOHP' => '081231959192',
           ]);
           // Assert the response status code
           $response->assertStatus(201);
           $data = $response->json();
            // Access the 'mahasiswa' array and then get the 'id'
            $this->login = [
                'name' => $data['user']['name'],
                'password' => '123',
            ];
            return $this->login;
       }
       /** @test */
       public function testLogin1()
       {
           $response = $this->json('POST', 'api/login',
           [
           ]);
           // Assert the response status code
           $response->assertStatus(422);
       }
        /** @test */
        public function testLogin2()
        {
            $response = $this->json('POST', 'api/login',
            [
                'name' => 'Jason',
                'password' => '121',
            ]);
            // Assert the response status code
            $response->assertStatus(401);
        }
          /** 
     * @test
     * @depends testRegister2
     */
      public function testLogin3($login)
      {
          $response = $this->json('POST', 'api/login',[
           'name' => $login['name'],
           'password' => $login['password'],
          ]);
          // Assert the response status code
          $response->assertStatus(200);
      }

      public function testLogout()
      {
          $response = $this->json('POST', 'api/logout',[
          ]);
          // Assert the response status code
          $response->assertStatus(200);
      }
      
}
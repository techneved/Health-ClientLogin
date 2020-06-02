<?php

namespace Techneved\Client\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Techneved\Client\Tests\TestCase;
use Techneved\Client\Tests\Traits\Custom;
use Tymon\JWTAuth\Facades\JWTAuth;

class ClientLoginTest extends TestCase
{
    use RefreshDatabase, Custom;

    protected $client;

     public function setUp(): void
     {
         parent::setUp();

         $this->client = $this->createClient();
         $this->actingAs($this->client, 'client-logins');

     }

    /**
     * Check required fields validations of instructor login
     *
     * @return void
     * @test
     */
    public function check_required_fields_validations()
    {
        $credentails = [
            'mobile' => '',
            'password' => '',
        ];

        $response = $this->postJson(route('client.login'), $credentails);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertExactJsonStructure([
            'mobile',
            'password',
        ], $response, 'errors');
    }

    /**
     * Check mobile number field validations of instructor login
     *
     * @return void
     *
     * @test
     */
    public function check_mobile_number_field_validations()
    {
        $credentails = [
            'mobile' => 'asdfasdf',
            'password' => 'asfdasd',
        ];

        $response = $this->postJson(route('client.login'), $credentails);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertExactJsonStructure([
            'mobile',
        ], $response, 'errors');

        //10 digit validation
        $credentails = [
            'mobile' => '12345678909',
            'password' => 'asfdasd',
        ];

        $response = $this->postJson(route('client.login'), $credentails);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertExactJsonStructure([
            'mobile',
        ], $response, 'errors');
    }

    /**
     * Check invalid credentials of instructor login
     *
     * @return void
     * @test
     */
    public function check_invalid_credentials()
    {
        $credentails = [
            'mobile' => 1234567899,
            'password' => 'asfdasd',
        ];

        $response = $this->postJson(route('client.login'), $credentails);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertExactJsonStructure([
            'error'
        ], $response, 'errors');
    }

    /**
     * Check valid credentials of instructor login
     *
     * @return void
     * @test
     */
    public function check_valid_credentials()
    {
       

        $credentails = [
            'mobile' => $this->client->mobile,
            'password' => 'password',
        ];


        $response = $this->postJson(route('client.login'), $credentails);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertExactJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'client'
        ], $response, 'data');
    }

    /**
     * Check unactive status with valid credentials of instructor login
     *
     * @return void
     * @test
     */
    public function check_unactive_status_with_valid_credentials()
    {
        $this->withoutExceptionHandling();
        $client = $this->createClientUnActive();
        $credentails = [
            'mobile' => $client->mobile,
            'password' => 'password',
        ];
        $response = $this->postJson(route('client.login'), $credentails);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertExactJsonStructure([
            'error'
        ], $response, 'errors');
    }


    /**
     * Check logout of instructor login
     *
     * @return void
     * @test
     */
    public function check_logout_credentials()
    {
        //$this->withoutExceptionHandling();
        $this->assertTrue(auth('client-logins')->check());
        $token = JWTAuth::fromUser($this->client);

        $response_second = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])
            ->postJson(route('client.logout'));

        $response_second->assertStatus(Response::HTTP_OK);
        $this->assertFalse(auth('client-logins')->check());
    }


    public function testExample()
    {
        $this->assertTrue(true);
    }

}


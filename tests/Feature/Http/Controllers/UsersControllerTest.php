<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Infrastructure\Redis\Repositories\UserRepository;
use Mockery;
use Storage;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    public function test_list_route(): void
    {
        $response = $this->get('/api/users');
        $this->assertTrue($response->json('success'));
        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_register_nickname_duplicate(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->instance(UserRepository::class, Mockery::mock(UserRepository::class, static function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('register')
                ->andReturn(false)
                ->once();
        }));

        $response = $this->post('/api/users/register', [
            'nickname' => 'foo',
            'avatar' => $file,
        ]);

        $response->assertStatus(409);

    }

    public function test_register_nickname_validation_fails(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/api/users/register', [
            'nickname' => null,
            'avatar' => $file,
        ], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('nickname');
    }
}

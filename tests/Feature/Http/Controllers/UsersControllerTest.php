<?php

namespace Feature\Http\Controllers;

use Domains\User\Infrastructure\Repositories\Redis\UserRedisReadRepository;
use Domains\User\Infrastructure\Repositories\Redis\UserRedisWriteRepository;
use Illuminate\Http\UploadedFile;
use Mockery;
use Storage;
use Tests\TestCase;

class UsersControllerTest extends TestCase
{
    public function test_list_route(): void
    {
        $this->instance(UserRedisReadRepository::class,
            Mockery::mock(UserRedisReadRepository::class, static function (Mockery\MockInterface $mock) {
                $mock->shouldReceive('list')
                    ->andReturn([
                        [
                            'nickname' => 'foo',
                            'avatar' => 'bar',
                        ],
                    ])
                    ->once();
            }));

        $response = $this->get('/api/users');
        $this->assertTrue($response->json('success'));
        $this->assertArrayHasKey('data', $response->json());
    }

    public function test_register_nickname_duplicate(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('avatar.jpg');

        $this->instance(UserRedisWriteRepository::class, Mockery::mock(UserRedisWriteRepository::class, static function (Mockery\MockInterface $mock) {
            $mock->shouldReceive('save')
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

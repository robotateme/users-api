<?php

namespace Tests\Feature\Http\Middleware;

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class ThrottleTest extends TestCase
{
    public function test_register_throttle_rate_limit(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->postJson('/api/users/register', [
                'nickname' => 'nickname00'.$i,
                'avatar' => $this->fakeAvatar(),
            ])
                ->assertStatus(201);
        }

        $this->postJson('/api/users/register', [
            'nickname' => 'nickname0012',
            'avatar' => $this->fakeAvatar(),
        ])
            ->assertStatus(429)
            ->assertJson([
                'message' => 'Too many requests',
            ]);
    }

    public function test_list_throttle_rate_limit(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->get('/api/users')
                ->assertStatus(200);
        }

        $this->get('/api/users')
            ->assertStatus(429)
            ->assertJson([
                'message' => 'Too many requests',
            ]);
    }

    private function fakeAvatar(): File
    {
        return UploadedFile::fake()
            ->image('avatar.jpg', 100, 100)
            ->size(100);
    }
}

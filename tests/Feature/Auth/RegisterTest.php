<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * test register route is ok
     */
    public function test_register_view()
    {
        if (!get_option('allow_register')) {
            $this->markTestSkipped('REGISTER support is not enabled.');
        }
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    /**
     * test register is ok without number
     */
    public function test_register_success_without_number()
    {
        if (!get_option('allow_register')) {
            $this->markTestSkipped('REGISTER support is not enabled.');
        }
        $response = $this->post(route('register.post'),[
            'full_name' => 'Anonymous',
            'email' => Str::random('8').'@zagreus.company',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('panel.index'));

    }

    /**
     * test register is ok with number
     */
    public function test_register_success_with_number()
    {
        if (!get_option('allow_register')) {
            $this->markTestSkipped('REGISTER support is not enabled.');
        }
        $response = $this->post(route('register.post'),[
            'full_name' => 'Anonymous',
            'email' => Str::random('8').'@zagreus.company',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'number' => '+98123546789'
        ]);
        $this->assertAuthenticated();
        $response->assertRedirect(route('panel.index'));

    }

}

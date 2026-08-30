<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Bienvenue');
        $response->assertSee('Connectez-vous à votre compte pour continuer.');
        $response->assertSee('Email ou Utilisateur');
        $response->assertSee('Mot de passe');
        $response->assertSee('Rester connecté');
        $response->assertSee('Se Connecter');
        $response->assertSee('MUPAKA');
        $response->assertSee('SHAMBA LETU');
        $response->assertSee('Commerce Transfrontalier pour la paix');
        $response->assertSee('images/Picture1.jpg');
        $response->assertSee('images/alert.png');
        $response->assertSee('images/swiss.jpg');
        $response->assertSee('images/swede.png');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

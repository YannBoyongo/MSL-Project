<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Mupaka Samba Letu');
        $response->assertSee('Accueil');
        $response->assertSee('Apropos');
        $response->assertSee('Actualités');
        $response->assertSee('CONTACT');
        $response->assertSee('Notre Projet');
        $response->assertSee('LIRE PLUS');
        $response->assertSee('Prix du jour');
        $response->assertSee('Taux de change');
        $response->assertSee('Signaler un problème');
        $response->assertSee('6000+');
        $response->assertSee('4500+');
        $response->assertSee('2300+');
        $response->assertSee('800+');
        $response->assertSee('crossBorderMap');
        $response->assertSee("Plus d'actualité", false);
        $response->assertSee('Nos Partenaires');
        $response->assertSee('DR CONGO | RWANDA | BURUNDI');
        $response->assertSee('images/swiss.jpg');
        $response->assertSee('images/swede.png');
        $response->assertSee('aria-label="X (Twitter)"', false);
        $response->assertSee('aria-label="LinkedIn"', false);
        $response->assertSee('aria-label="Facebook"', false);
    }
}

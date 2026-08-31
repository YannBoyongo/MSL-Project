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
        $response->assertSee('aria-label="Retour en haut"', false);
    }

    public function test_about_page_returns_a_successful_response_with_breadcrumb(): void
    {
        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('Mupaka Samba Letu');
        $response->assertSee('Accueil');
        $response->assertSee('A propos');
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('images/breadcomb.png');
        $response->assertSee("Mupaka : un exemple de l'approche NEXUS", false);
        $response->assertSee('Objectif principal');
        $response->assertSee('Approche');
        $response->assertSee('Adaptations');
    }

    public function test_news_page_returns_a_successful_response_with_breadcrumb(): void
    {
        $response = $this->get(route('news'));

        $response->assertStatus(200);
        $response->assertSee('Mupaka Samba Letu');
        $response->assertSee('Accueil');
        $response->assertSee('Actualités');
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('images/breadcomb.png');
        $response->assertSee('Filtrer les résultats');
        $response->assertSee('Flash (3)');
        $response->assertSee('Evénement (3)');
        $response->assertSee('Communiqués de presse(3)');
        $response->assertSee("Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.", false);
        $response->assertSee('Publié le 09 Août 2026');
        $response->assertSee('Lire plus');
        $response->assertSee("Plus d'actualités", false);
    }

    public function test_news_show_page_returns_a_successful_response(): void
    {
        $response = $this->get(route('news.show', 'fermeture-frontiere-bukavu-ebola'));

        $response->assertStatus(200);
        $response->assertSee('Mupaka Samba Letu');
        $response->assertSee('Accueil');
        $response->assertSee('Actualités');
        $response->assertSee('Détail actualité');
        $response->assertSee('images/breadcomb.png');
        $response->assertSee('Retour aux actualités');
        $response->assertSee("Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.", false);
        $response->assertSee('Publié le 09 Août 2026');
        $response->assertSee('Partager :');
    }
}

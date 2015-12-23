<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $this->visit('/auth')
            ->type('erwan.lutin@nomail.com', 'email')
            ->type('erwan','password')
            ->press('S\'authentifier');

        $crawler = $this->crawler;

        $element = $crawler->filter('a')->eq(0);

        $this->visit('/items')
            ->click("<a>")
            ->see('Voulez-vous supprimer cet article ?');
    }
}

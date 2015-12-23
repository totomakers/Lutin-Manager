<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemCreationTest extends TestCase
{

    use DatabaseTransactions;

    public function testItemCreation()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->type('produit test','name')
            ->type('123','weight')
            ->press('ajouter')
            ->see('Article créé');
    }

    public function testItemCreationBelowZero()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->type('produit test','name')
            ->type('123','weight')
            ->press('ajouter')
            ->see("Impossible de créer l'article");
    }

    public function testItemCreationNameNull()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->type('','name')
            ->type('123','weight')
            ->press('ajouter')
            ->see("Impossible de créer l'article");
    }

    public function testItemCreationWeightNull()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->type('produit','name')
            ->type('','weight')
            ->press('ajouter')
            ->see("Impossible de créer l'article");
    }

    public function testItemCreationAllNull()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->type('','name')
            ->type('','weight')
            ->press('ajouter')
            ->see("Impossible de créer l'article");
    }

}

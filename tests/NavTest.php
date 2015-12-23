<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NavTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testManagerNavItems()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders')
            ->click('Gestion des Articles')
            -> seePageIs('items');

    }
    public function testManagerNavUsers()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders')
            ->click('Gestion des EmployÃ©s')
            -> seePageIs('/users');

    }
    public function testManagerNavOrders()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders')
            ->click('Gestion des Articles')
            ->seePageIs('/items')
            ->click('Liste des Commandes')
            ->seePageIs('/orders')
            ->see('importer');
    }

    //Page interdite au manager
    public function testManagerDeliveryNote()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/delivery-note')
            ->see('Ooops ! Cette page aété mangé par le Grinch !');
    }

    //Page des lutins
    public function testSantasHelpersOrders()
    {
        $this->visit('/auth')
            ->type('erwan.lutin@nomail.com', 'email')
            ->type('erwan','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders')
            ->dontSee('importer');
    }

    //Page inerdite aux lutins
    public function testSantasHelpersUsers()
    {
        $this->visit('/auth')
            ->type('erwan.lutin@nomail.com', 'email')
            ->type('erwan','password')
            ->press('S\'authentifier')
           ->visit('/users')
            ->see('Ooops ! Cette page aété mangé par le Grinch !');
    }

    //Page interdite aux lutins
    public function testSantasHelpersItems()
    {
        $this->visit('/auth')
            ->type('erwan.lutin@nomail.com', 'email')
            ->type('erwan','password')
            ->press('S\'authentifier')
            ->visit('/items')
            ->see('Ooops ! Cette page aété mangé par le Grinch !');
    }

}

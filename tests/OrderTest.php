<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    const ROUTE = '/auth';


    public function testEmailvide()
    {

        $this->visit(self::ROUTE)
            ->type('', 'email')
            ->type('test','password')
            ->press('S\'authentifier')
            ->see(' Nom d\'utilisateur ou Mot de passe invalide');
    }


}

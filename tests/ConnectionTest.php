<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConnectionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

        public function testUserLogin()
    {
        $this->visit('/doit')
            ->type('test@test.com', 'email')
            ->type('test','password')
            ->press('S\'authentifier')
            ->see(' Nom d\'utilisateur ou Mot de passe invalide');
    }
}

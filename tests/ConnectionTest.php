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
            ->type('Joel', 'Identifiant')
            ->type('test','mdp')
            ->press('Register')
            ->see('/dashboard');
    }
}

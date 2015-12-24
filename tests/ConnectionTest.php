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

    public function testEmailvide()
    {
        $this->visit('/auth')
            ->type('', 'email')
            ->type('test','password')
            ->press('S\'authentifier')
            ->seePageIs('/auth');
    }

    public function testMdpVide()
    {
        $this->visit('/auth')
            ->type('jo@el.com', 'email')
            ->type('','password')
            ->press('S\'authentifier')
            ->seePageIs('/auth');
    }

    public function testLoginMdpVide()
    {
        $this->visit('/auth')
            ->type('', 'email')
            ->type('','password')
            ->press('S\'authentifier')
            ->seePageIs('/auth');
    }

    public function testManagerOK()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders');
    }

    public function testEmployeOK()
    {
        $this->visit('/auth')
            ->type('james.lutin@nomail.com', 'email')
            ->type('james','password')
            ->press('S\'authentifier')
            ->seePageIs('/orders');
    }

    //mdp + login faux

    //mdp faux + login vrai

    // login faux + mdp vrai

}

<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmployeeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEmployeeCreation()
    {
        $this->visit('/auth')
        ->type('joel.pere@nomail.com', 'email')
        ->type('joel','password')
        ->press('S\'authentifier')
        ->visit('/users')
        ->type('Test Employe', 'name')
        ->select('Employé','rank')
        ->type('test@test.com','email')
        ->type('Test123','password');
    }
}

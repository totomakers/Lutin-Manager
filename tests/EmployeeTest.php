<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmployeeTest extends TestCase
{
    use DatabaseTransactions;


    public function testEmployeeCreation()
    {
        $this->visit('/auth')
        ->type('joel.pere@nomail.com', 'email')
        ->type('joel','password')
        ->press('S\'authentifier')
        ->visit('/users')
        ->type('Test Employe', 'name')
        ->select('0','rank')
        ->type('test@test.com','email')
        ->type('Test123','password')
        ->press('ajouter')
        ->see('L\'utilisateur :username a été créé.');
    }

    public function testEmployeeAlreadyExists()
    {

        $this->visit('/auth')
        ->type('joel.pere@nomail.com', 'email')
        ->type('joel','password')
        ->press('S\'authentifier')
        ->visit('/users')
        ->type('Test Employe', 'name')
        ->select('0','rank')
        ->type('test@test.com','email')
        ->type('Test123','password')
        ->press('ajouter');

        $this->visit('/auth')
        ->type('joel.pere@nomail.com', 'email')
        ->type('joel','password')
        ->press('S\'authentifier')
        ->visit('/users')
        ->type('Test Employe', 'name')
        ->select('0','rank')
        ->type('test@test.com','email')
        ->type('Test123','password')
        ->press('ajouter')
        ->see('L\'utilisateur existe déjà.');
    }


    public function testEmployeeCreationBadEmail()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/users')
            ->type('Test Employe3', 'name')
            ->select('0','rank')
            ->type('test','email')
            ->type('Zt3dsfsdfsf','password')
            ->press('ajouter')
            ->see('Le champ email n\'est pas correct.');
    }

    public function testEmployeeCreationPwdShort()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/users')
            ->type('Test Employe1', 'name')
            ->select('0','rank')
            ->type('test1@test.com','email')
            ->type('Tst3','password')
            ->press('ajouter')
            ->see('Le champ password n\'est pas correct.');
    }

    public function testEmployeeCreationPwdLong()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/users')
            ->type('Test Employe2', 'name')
            ->select('0','rank')
            ->type('test2@test.com','email')
            ->type('Tst3dsfsdfsdfdssdf','password')
            ->press('ajouter')
            ->see('Le champ password n\'est pas correct.');
    }

    public function testEmployeeCreationNoCaps()
    {
        $this->visit('/auth')
            ->type('joel.pere@nomail.com', 'email')
            ->type('joel','password')
            ->press('S\'authentifier')
            ->visit('/users')
            ->type('Test Employe3', 'name')
            ->select('0','rank')
            ->type('test3@test.com','email')
            ->type('st3dsf','password')
            ->press('ajouter')
            ->see('Le champ password n\'est pas correct.');
    }
}

<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', "Serie's detail");
    }
    public function testCreateSerieIsWorking(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/serie/add');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
        $this->assertResponseRedirects("/login", 302);
    }
    public function testCreateSerieIsWorkingIfLogged(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/serie/add');
        //permet de recuperer tous les services
        $userRepository = static ::getContainer()->get(UserRepository::class);
        $user =$userRepository->findOneBy(['email'=>'a.mod@gmail.com']);
        $client->loginUser($user);
        $this->assertResponseIsSuccessful();
    }
}

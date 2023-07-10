<?php

namespace App\Tests\Controller;

use App\Controller\PaymentController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentControllerTest extends WebTestCase
{

    public function testCalcPrice()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/payment/calc',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'phone' => 123,
                'iso' => 'RU',
            ])
        );

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('authCode', $responseData);

    }
}

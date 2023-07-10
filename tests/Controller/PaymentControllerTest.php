<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentControllerTest extends WebTestCase
{
    public function testCalcPrice(): void
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
                'product' => (string) $this->getProduct()->getId(),
                'taxNumber' => 'GR123456789',
                'couponCode' => 'P06',
                'paymentProcessor' => 'paypal',
            ])
        );

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('price', $responseData);
        $this->assertEquals('116.56', $responseData['price']);
    }

    public function testCalcPriceFail(): void
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
                'product' => '-1',
                'taxNumber' => 'GR126789',
                'couponCode' => 'UNKNOWN',
                'paymentProcessor' => 'invalid',
            ])
        );

        $this->assertResponseStatusCodeSame(400);
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('exception', $responseData);
        $this->assertArrayHasKey('message', $responseData['exception']);
        $this->assertArrayHasKey('violations', $responseData['exception']);
        $this->assertEquals([
            'product' => ['This value is not valid.'],
            'taxNumber' => ['Invalid tax'],
            'paymentProcessor' => ['This value is not valid.'],
            'couponCode' => ['This value is not valid.'],
        ], $responseData['exception']['violations']);
    }

    public function testProcess(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/payment/process',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'product' => (string) $this->getProduct()->getId(),
                'taxNumber' => 'DE123456789',
                'couponCode' => 'F10',
                'paymentProcessor' => 'stripe',
            ])
        );

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('status', $responseData);
        $this->assertArrayHasKey('purchaseId', $responseData);
    }

    private function getProduct(): Product
    {
        $em = self::getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository(Product::class);

        return $repo->createQueryBuilder('p')
            ->andWhere('p.name = :name')
            ->setParameter('name', 'Iphone')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

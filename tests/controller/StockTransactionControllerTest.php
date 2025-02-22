<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StockTransactionControllerTest extends WebTestCase
{
    public function testByStocks(): void
    {
        $client = static::createClient();

        $client->request('GET', '/stock/transaction');

        $this->assertResponseIsSuccessful();

        $transport = $this->getContainer()->get('messenger.transport.async');
        $this->assertCount(0, $transport->getSent());
    }
}
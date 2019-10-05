<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class Transparencia
{
    const BASE_URI = 'http://www.transparencia.gov.br';

    private $client;

    public function  __construct(Client $client)
    {
        $this->client = $client;
    }

    public function searchBolsaFamilia(string $yearMonth, string $ibgeCityCode, int $page)
    {
        $response = $this->request('GET', '/bolsa-familia-por-municipio', [
            'mesAno' => $yearMonth,
            'codigoIbge' => $ibgeCityCode,
            'pagina' => $page
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        };

        throw new Exception("Erro ao consultar dados do bolsa família: " . $response->getBody());
    }

    private function request(string $method, string $path, array $data)
    {
        $options = [];

        switch ($method) {
            case 'GET':
                $options['query'] = $data;
                break;
            default:
                throw new Exception("Invalid method '{$method}'");
        }

        return $this->client->request($method, "/api-de-dados{$path}", $options);
    }
}

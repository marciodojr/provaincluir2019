<?php

namespace App\Services;

use DateTime;
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

    public function searchBolsaFamilia(string $yearMonth, string $ibgeCityCode, int $pagina)
    {
        $response = $this->request('GET', '/bolsa-familia-por-municipio', [
            'mesAno' => $yearMonth,
            'codigoIbge' => $ibgeCityCode,
            'pagina' => $pagina
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents(), true);
        };

        throw new Exception("Erro ao consultar dados do bolsa família: " . $response->getBody());
    }

    public function searchLicitacoes(string $startDate, string $endDate, string $codigoSIAFI, int $pagina)
    {
        $response = $this->request('GET', '/licitacoes', [
            'dataInicial' => $startDate,
            'dataFinal' => $endDate,
            'codigoOrgao' => $codigoSIAFI,
            'pagina' => $pagina
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

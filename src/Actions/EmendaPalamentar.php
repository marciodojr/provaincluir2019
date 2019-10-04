<?php

declare(strict_types=1);

namespace App\Actions;

use App\Services\Transparencia;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EmendaPalamentar extends Action
{
    private $transparencia;

    public function __construct(Transparencia $transparencia)
    {
        $this->transparencia = $transparencia;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $params = $request->getQueryParams();

        if (empty($params['ano'])) {
            throw new Exception("Ano não informado");
        }

        $year = $params['ano'];
        if ($year < 2010 || $year > 2018) {
            throw new Exception("Ano '${$year}' não é válido. Forneça um ano entre 2010 e 2018");
        }

        $totalSize = 0;
        set_time_limit(0);
        do {
            $pageNum = 0;
            $pageChunk = $this->transparencia->searchEmendaParlamentar($year, ++$pageNum);
            $totalSize += count($pageChunk);
        } while ($pageChunk);
        set_time_limit(30);

        return $this->toJson($response, [
            'total_resultados' => $totalSize
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Actions;

use App\Services\Transparencia;
use Psr\Http\Message\ResponseInterface;

class BolsaFamiliaMunicipio extends Action
{
    private $transparencia;

    public function __construct(Transparencia $transparencia)
    {
        $this->transparencia = $transparencia;
    }

    public function __invoke(ResponseInterface $response)
    {
        $data = $this->transparencia->searchBolsaFamilia('201901', '3132404', 1);

        return $this->toJson($response, $data);
    }
}

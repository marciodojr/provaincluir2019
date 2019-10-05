<?php

declare(strict_types=1);

use App\Actions\BolsaFamiliaMunicipio;
use App\Actions\Municipio;
use App\Actions\Root;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', Root::class);
    $app->group('/bolsa-familia', function (Group $group) {
        $group->get('/municipio', BolsaFamiliaMunicipio::class);
    });
    $app->get('/municipio', Municipio::class);
};

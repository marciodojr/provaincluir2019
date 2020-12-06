<?php

declare(strict_types=1);

namespace App\DbFixtures;

use App\Entities\Licitacao;
use App\Entities\Municipio;
use App\Services\Transparencia;
use DateInterval;
use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LicitacaoLoader implements FixtureInterface
{
    private $tranparencia;
    private $dataInicial;
    private $dataFinal;
    private $codigoSIAFI;

    public function __construct(Transparencia $tr, DateTime $dataInicial, DateTime $dataFinal, string $codigoSIAFI)
    {
        $this->tranparencia = $tr;
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
        $this->codigoSIAFI = $codigoSIAFI;
    }

    public function load(ObjectManager $manager)
    {
        $intervals = $this->getIntervals();
        $municipio = null;

        foreach ($intervals as $interval) {
            $licitacoes = $this->tranparencia->searchLicitacoes($interval['data_inicial'], $interval['data_final'], $this->codigoSIAFI, 1);

            if (!$licitacoes) {
                continue;
            }

            foreach ($licitacoes as $licitacao) {

                $codigoIbge = $licitacao['municipio']['codigoIBGE'];
                if (!$municipio || $municipio->codigoIbge != $codigoIbge) {
                    $municipio = $manager->getRepository(Municipio::class)->findOneBy([
                        'codigoIbge' => $codigoIbge
                    ]);
                }

                if (!$municipio) {
                    continue;
                }

                $bf = $this->instanciateLicitacao($municipio, $licitacao);
                $manager->persist($bf);
            }
        }

        $manager->flush();
    }

    private function getIntervals()
    {
        $intervals = [];
        for ($i = clone $this->dataInicial; $i < $this->dataFinal; $i->add(new DateInterval('P1M'))) {
            $intervals[] =  [
                'data_inicial' => $i->format('d/m/Y'),
                'data_final' => $i->format('t/m/Y')
            ];
        }

        return $intervals;
    }

    private function instanciateLicitacao(Municipio $m, array $data)
    {
        $dataReferencia = DateTime::createFromFormat('d/m/Y', $data['dataReferencia']);
        $codigoOrgao = (int) $data['unidadeGestora']['orgaoVinculado']['codigoSIAFI'];
        $nomeOrgao = $data['unidadeGestora']['orgaoVinculado']['nome'];
        $dataPublicacao = DateTime::createFromFormat('d/m/Y', $data['dataPublicacao']);
        $dataResultadoCompra = $data['dataResultadoCompra'] ? DateTime::createFromFormat('d/m/Y', $data['dataResultadoCompra']) : null;
        $objetoLicitacao = $data['licitacao']['objeto'];
        $numeroLicitacao = $data['licitacao']['numero'];
        $responsavelContato = $data['licitacao']['contatoResponsavel'];

        return new Licitacao(
            $m,
            $dataReferencia,
            $codigoOrgao,
            $nomeOrgao,
            $dataPublicacao,
            $dataResultadoCompra,
            $objetoLicitacao,
            $numeroLicitacao,
            $responsavelContato
        );
    }
}

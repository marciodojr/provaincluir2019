<?php

declare(strict_types=1);


namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

use JsonSerializable;

/**
 * @Table(
 *      name="licitacao",
 *      indexes={
 *          @Index(name="data_referencia_idx", columns={"data_referencia"})
 *      }
 * )
 * @Entity
 */
class Licitacao implements JsonSerializable
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Municipio", inversedBy="licitacoes", fetch="EAGER")
     * @var Municipio
     */
    private $municipio;

    /**
     * @Column(name="data_referencia", type="date")
     */
    private $dataReferencia;

    /**
     * @Column(name="codigo_orgao", type="integer")
     */
    private $codigoOrgao;

    /**
     * @Column(name="nome_orgao", type="string", length=255)
     */
    private $nomeOrgao;

    /**
     * @Column(name="data_publicacao", type="date")
     */
    private $dataPublicacao;

    /**
     * @Column(name="data_resultado_compra", type="date", nullable=true)
     */
    private $dataResultadoCompra;

    /**
     * @Column(name="objeto_licitacao", type="string", length=1000)
     */
    private $objetoLicitacao;

    /**
     * @Column(name="numero_licitacao", type="string", length=30)
     */
    private $numeroLicitacao;

    /**
     * @Column(name="responsavel_contrato", type="string", length=255)
     */
    private $responsavelContrato;

    public function __construct(
        Municipio $municipio,
        DateTime $dataReferencia,
        int $codigoOrgao,
        string $nomeOrgao,
        DateTime $dataPublicacao,
        ?DateTime $dataResultadoCompra,
        string $objetoLicitacao,
        string $numeroLicitacao,
        string $responsavelContrato
    ) {
        $this->municipio = $municipio;
        $this->dataReferencia =  $dataReferencia;
        $this->codigoOrgao =  $codigoOrgao;
        $this->nomeOrgao =  $nomeOrgao;
        $this->dataPublicacao = $dataPublicacao;
        $this->dataResultadoCompra = $dataResultadoCompra;
        $this->objetoLicitacao = $objetoLicitacao;
        $this->numeroLicitacao = $numeroLicitacao;
        $this->responsavelContrato = $responsavelContrato;
    }

    /**
     * Access private properties like public properties (in read-only mode)
     */
    public function __get($name)
    {
        return $this->$name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'municipio' => $this->municipio->nomeCidade,
            'data_referencia' => $this->dataReferencia->format('d/m/Y'),
            'codigo_orgao' => $this->codigoOrgao,
            'nome_orgao' => $this->nomeOrgao,
            'data_publicacao' => $this->dataPublicacao->format('d/m/Y'),
            'data_resultado_compra' => $this->dataResultadoCompra ? $this->dataResultadoCompra->format('d/m/Y') : null,
            'objeto_licitacao' => $this->objetoLicitacao,
            'numero_licitacao' => $this->numeroLicitacao,
            'responsavel_contrato' => $this->responsavelContrato,
        ];
    }
}

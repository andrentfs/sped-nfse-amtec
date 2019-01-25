<?php

namespace NFePHP\NFSeAmtec\Common;

/**
 * Class for RPS XML convertion
 *
 * @category  NFePHP
 * @package   NFePHP\NFSeAmtec
 * @copyright NFePHP Copyright (c) 2008-2018
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfse-nacional for the canonical source repository
 */

use stdClass;
use NFePHP\Common\DOMImproved as Dom;
use DOMNode;
use DOMElement;

class Factory
{
    /**
     * @var stdClass
     */
    protected $std;
    /**
     * @var Dom
     */
    protected $dom;
    /**
     * @var DOMNode
     */
    protected $rps;

    /**
     * Constructor
     * @param stdClass $std
     */
    public function __construct(stdClass $std)
    {
        $this->std = $std;
        
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
        $this->rps = $this->dom->createElement('Rps');
    }
    
    /**
     * Builder, converts sdtClass Rps in XML Rps
     * NOTE: without Prestador Tag
     * @return string RPS in XML string format
     */
    public function render()
    {
        $infRps = $this->dom->createElement('InfDeclaracaoPrestacaoServico');
        $att = $this->dom->createAttribute('xmlns');
        $att->value = 'http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd';
        $infRps->appendChild($att);
        
        $innerRPS = $this->dom->createElement('Rps');
        $att = $this->dom->createAttribute('Id');
        $att->value = $this->std->identificacaorps->numero; //.$this->std->identificacaorps->serie;
        $innerRPS->appendChild($att);
        
        $this->addIdentificacao($innerRPS);
        
        $this->dom->addChild(
            $innerRPS,
            "DataEmissao",
            $this->std->dataemissao,
            true
        );
        $this->dom->addChild(
            $innerRPS,
            "Status",
            $this->std->status,
            true
        );
        $infRps->appendChild($innerRPS);
        
        $this->addServico($infRps);
        $this->addTomador($infRps);
        $this->addIntermediario($infRps);
        $this->addConstrucao($infRps);

        $this->rps->appendChild($infRps);
        $this->dom->appendChild($this->rps);
        return $this->dom->saveXML();
    }
    
    /**
     * Includes Identificacao TAG in parent NODE
     * @param DOMNode $parent
     */
    protected function addIdentificacao(&$parent)
    {
        $id = $this->std->identificacaorps;
        $node = $this->dom->createElement('IdentificacaoRps');
        $this->dom->addChild(
            $node,
            "Numero",
            $id->numero,
            true
        );
        $this->dom->addChild(
            $node,
            "Serie",
            $id->serie,
            true
        );
        $this->dom->addChild(
            $node,
            "Tipo",
            $id->tipo,
            true
        );
        $parent->appendChild($node);
    }
    
    /**
     * Includes Servico TAG in parent NODE
     * @param DOMNode $parent
     */
    protected function addServico(&$parent)
    {
        $serv = $this->std->servico;
        $val = $this->std->servico->valores;
        $node = $this->dom->createElement('Servico');
        $valnode = $this->dom->createElement('Valores');
        $this->dom->addChild(
            $valnode,
            "ValorServicos",
            number_format($val->valorservicos, 2, '.', ''),
            true
        );
        $this->dom->addChild(
            $valnode,
            "ValorPis",
            isset($val->valorpis)
                ? number_format($val->valorpis, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "ValorCofins",
            isset($val->valorcofins)
                ? number_format($val->valorcofins, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "ValorInss",
            isset($val->valorinss)
                ? number_format($val->valorinss, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "ValorCsll",
            isset($val->valorcsll)
                ? number_format($val->valorcsll, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "OutrasRetencoes",
            isset($val->outrasretencoes)
                ? number_format($val->outrasretencoes, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "ValorIss",
            isset($val->valoriss)
                ? number_format($val->valoriss, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "Aliquota",
            isset($val->aliquota)
                ? number_format($val->aliquota, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "DescontoIncondicionado",
            isset($val->descontoincondicionado)
                ? number_format($val->descontoincondicionado, 2, '.', '')
                : null,
            false
        );
        $this->dom->addChild(
            $valnode,
            "DescontoCondicionado",
            isset($val->descontocondicionado)
                ? number_format($val->descontocondicionado, 2, '.', '')
                : null,
            false
        );
        $node->appendChild($valnode);
        $this->dom->addChild(
            $node,
            "CodigoTributacaoMunicipio",
            $serv->codigotributacaomunicipio,
            true
        );
        $this->dom->addChild(
            $node,
            "Discriminacao",
            $serv->discriminacao,
            true
        );
        $this->dom->addChild(
            $node,
            "CodigoMunicipio",
            $serv->codigomunicipio,
            true
        );

        $parent->appendChild($node);
    }
    
    /**
     * Includes Tomador TAG in parent NODE
     * @param DOMNode $parent
     */
    protected function addTomador(&$parent)
    {
        if (!isset($this->std->tomador)) {
            return;
        }
        $tom = $this->std->tomador;
        
        $node = $this->dom->createElement('Tomador');
        $ide = $this->dom->createElement('IdentificacaoTomador');
        $cpfcnpj = $this->dom->createElement('CpfCnpj');
        if (isset($tom->cnpj)) {
            $this->dom->addChild(
                $cpfcnpj,
                "Cnpj",
                $tom->cnpj,
                true
            );
        } else {
            $this->dom->addChild(
                $cpfcnpj,
                "Cpf",
                $tom->cpf,
                true
            );
        }
        $ide->appendChild($cpfcnpj);
        $this->dom->addChild(
            $ide,
            "InscricaoMunicipal",
            isset($tom->inscricaomunicipal) ? $tom->inscricaomunicipal : null,
            false
        );
        $node->appendChild($ide);
        $this->dom->addChild(
            $node,
            "RazaoSocial",
            $tom->razaosocial,
            true
        );
        if (!empty($this->std->tomador->endereco)) {
            $end = $this->std->tomador->endereco;
            $endereco = $this->dom->createElement('Endereco');
            $this->dom->addChild(
                $endereco,
                "Endereco",
                $end->endereco,
                true
            );
            $this->dom->addChild(
                $endereco,
                "Numero",
                $end->numero,
                true
            );
            $this->dom->addChild(
                $endereco,
                "Complemento",
                isset($end->complemento) ? $end->complemento : null,
                false
            );
            $this->dom->addChild(
                $endereco,
                "Bairro",
                $end->bairro,
                true
            );
            $this->dom->addChild(
                $endereco,
                "CodigoMunicipio",
                $end->codigomunicipio,
                true
            );
            $this->dom->addChild(
                $endereco,
                "Uf",
                $end->uf,
                true
            );
            $this->dom->addChild(
                $endereco,
                "Cep",
                !empty($end->cep) ? $end->cep : null,
                false
            );
            $node->appendChild($endereco);
        }
        $parent->appendChild($node);
    }
    
    /**
     * Includes Intermediario TAG in parent NODE
     * @param DOMNode $parent
     */
    protected function addIntermediario(&$parent)
    {
        if (!isset($this->std->intermediarioservico)) {
            return;
        }
        $int = $this->std->intermediarioservico;
        $node = $this->dom->createElement('Intermediario');
        $identifc = $this->dom->createElement('IdentificacaoIntermediario');
        $cpfcnpj = $this->dom->createElement('CpfCnpj');
        if (isset($int->cnpj)) {
            $this->dom->addChild(
                $cpfcnpj,
                "Cnpj",
                $int->cnpj,
                true
            );
        } else {
            $this->dom->addChild(
                $cpfcnpj,
                "Cpf",
                $int->cpf,
                true
            );
        }
        $identifc->appendChild($cpfcnpj);
        $this->dom->addChild(
            $identifc,
            "InscricaoMunicipal",
            $int->inscricaomunicipal,
            false
        );
        $node->appendChild($identifc);
        $this->dom->addChild(
            $node,
            "RazaoSocial",
            $int->razaosocial,
            true
        );
        $parent->appendChild($node);
    }
    
    /**
     * Includes Construcao TAG in parent NODE
     * @param DOMNode $parent
     */
    protected function addConstrucao(&$parent)
    {
        if (!isset($this->std->construcaocivil)) {
            return;
        }
        $obra = $this->std->construcaocivil;
        $node = $this->dom->createElement('ConstrucaoCivil');
        $this->dom->addChild(
            $node,
            "CodigoObra",
            $obra->codigoobra,
            true
        );
        $this->dom->addChild(
            $node,
            "Art",
            $obra->art,
            true
        );
        $parent->appendChild($node);
    }
}

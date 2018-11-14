<?php

namespace NFePHP\NFSeAmtec;

/**
 * Class for comunications with NFSe webserver in Nacional Standard
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

use NFePHP\NFSeAmtec\Common\Tools as BaseTools;
use NFePHP\NFSeAmtec\RpsInterface;
use NFePHP\Common\Certificate;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Validator;

class Tools extends BaseTools
{
    protected $xsdpath;
    
    public function __construct($config, Certificate $cert)
    {
        parent::__construct($config, $cert);
        $path = realpath('../storage/schemes');
        $this->xsdpath = $path . '/nfse_gyn_v02.xsd';
    }
    
    /**
     * Consulta NFSe por RPS (SINCRONO)
     * @param integer $numero
     * @param string $serie
     * @param integer $tipo
     * @return string
     */
    public function consultarNfsePorRps($numero, $serie, $tipo)
    {
        $operation = "ConsultarNfseRps";
        $content = "<{$operation}Envio "
            . "xmlns=\"{$this->wsobj->msgns}\">"
            . "<IdentificacaoRps>"
            . "<Numero>$numero</Numero>"
            . "<Serie>$serie</Serie>"
            . "<Tipo>$tipo</Tipo>"
            . "</IdentificacaoRps>"
            . $this->prestador
            . "</{$operation}Envio>";
        
        Validator::isValid($content, $this->xsdpath);
        return $this->send($content, $operation);
    }
    
    public function getNFSeHtml()
    {
        $url = "http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=1300687&nota=370&verificador=MB94-C3ZA";
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
        $path = "http://www2.goiania.go.gov.br";
        $data = str_replace('<img src="/sistemas/saces/imagem/brasao.gif" width="70">', "<img src=\"$path/sistemas/saces/imagem/brasao.gif\" width=\"70\">", $data);
        $data = str_replace('<img src="/sistemas/snfse/imagem/email_link.png" class="some" title="Link desta nota para envio ao tomador" border="0">', "<img src=\"$path/sistemas/snfse/imagem/email_link.png\" class=\"some\" title=\"Link desta nota para envio ao tomador\" border=\"0\">", $data);
        $data = iconv("ISO-8859-1//TRANSLIT", 'UTF-8', $data);
	return $data;
    }
   
    /**
     * Solicita a emissão de uma NFSe de forma SINCRONA
     * @param RpsInterface $rps
     * @param string $lote Identificação do lote
     * @return string
     */
    public function gerarNfse(RpsInterface $rps, $lote)
    {
        $operation = "GerarNfse";
        
        $xmlsigned = $this->putPrestadorInRps($rps);
        $xmlsigned = $this->sign($xmlsigned, 'InfRps', 'Id');
        
        $contentmsg = "<GerarNfseEnvio xmlns=\"{$this->wsobj->msgns}\">"
            . "<LoteRps Id=\"$lote\" versao=\"{$this->wsobj->version}\">"
            . "<NumeroLote>$lote</NumeroLote>"
            . "<Cnpj>" . $this->config->cnpj . "</Cnpj>"
            . "<InscricaoMunicipal>" . $this->config->im . "</InscricaoMunicipal>"
            . "<QuantidadeRps>1</QuantidadeRps>"
            . "<ListaRps>"
            . $xmlsigned
            . "</ListaRps>"
            . "</LoteRps>"
            . "</GerarNfseEnvio>";
        $content = $this->sign($contentmsg, 'LoteRps', 'Id');
        
        return $this->send($content, $operation);
    }
}

<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\NFSeAmtec\Tools;
use NFePHP\NFSeAmtec\Rps;
use NFePHP\NFSeAmtec\Common\Soap\SoapFake;
use NFePHP\NFSeAmtec\Common\FakePretty;

try {
    
    $config = [
        'cpf' => '24329550130',
        //'cnpj' => '99999999000191',
        'im' => '1442678',
        'cmun' => '5208707',
        'razao' => 'Empresa Test Ltda',
        'tpamb' => 1 //não existe diferença entre homologaçao e produção CUIDADO
    ];

    $configJson = json_encode($config);

    $content = file_get_contents('expired_certificate.pfx');
    $password = 'associacao';
    $cert = Certificate::readPfx($content, $password);
    
    $soap = new SoapFake();
    $soap->disableCertValidation(true);
    
    $tools = new Tools($configJson, $cert);
    $tools->loadSoapClass($soap);

    $std = new \stdClass();
    $std->version = '2.00';
    $std->IdentificacaoRps = new \stdClass();
    $std->IdentificacaoRps->Numero = 1; //limite 15 digitos
    $std->IdentificacaoRps->Serie = 'UNICA'; 
    $std->IdentificacaoRps->Tipo = 1; //1 - RPS 2-Nota Fiscal Conjugada (Mista) 3-Cupom
    $std->DataEmissao = '2011-08-12T00:00:00';
    $std->Status = 1;  // 1 – Normal  2 – Cancelado

    $std->Tomador = new \stdClass();
    //$std->Tomador->Cnpj = "00000000000000";
    $std->Tomador->Cpf = "28222148168";
    $std->Tomador->InscricaoMunicipal = '1708';
    $std->Tomador->RazaoSocial = "LUIZ AUGUSTO MARINHO NOLETO";

    
    $std->Tomador->Endereco = new \stdClass();
    $std->Tomador->Endereco->Endereco = 'RUA 3';
    $std->Tomador->Endereco->Numero = '1003';
    $std->Tomador->Endereco->Complemento = '1003';
    $std->Tomador->Endereco->Bairro = 'CENTRO';
    $std->Tomador->Endereco->CodigoMunicipio = 5208707;
    $std->Tomador->Endereco->Uf = 'GO';
    //$std->Tomador->Endereco->Cep = 30160010;
    
    $std->Servico = new \stdClass();
    $std->Servico->CodigoTributacaoMunicipio = '631190000';
    $std->Servico->Discriminacao = "TESTE DE WEBSERVICE SABETUDO"; //\s\n quebra de linha
    $std->Servico->CodigoMunicipio = 2530000;

    $std->Servico->Valores = new \stdClass();
    $std->Servico->Valores->ValorServicos = 6000.00;
    $std->Servico->Valores->ValorPis = 40.50;
    $std->Servico->Valores->ValorCofins = 40.50;
    $std->Servico->Valores->ValorInss = 10.50;
    $std->Servico->Valores->ValorCsll = 10.50;
    $std->Servico->Valores->DescontoIncondicionado = 500.00;
    
    //$std->IntermediarioServico = new \stdClass();
    //$std->IntermediarioServico->RazaoSocial = 'INSCRICAO DE TESTE SIATU - D AGUA -PAULINO S'; 
    //$std->IntermediarioServico->Cnpj = '99999999000191';
    //$std->IntermediarioServico->InscricaoMunicipal = '8041700010';
    
    //$std->ConstrucaoCivil = new \stdClass();
    //$std->ConstrucaoCivil->CodigoObra = '1234';
    //$std->ConstrucaoCivil->Art = '1234';
    
    $rps = new Rps($std);

    $lote = 1;

    $response = $tools->gerarNfse($rps, $lote);
    
    echo FakePretty::prettyPrint($response, '');
 
} catch (\Exception $e) {
    echo $e->getMessage();
}
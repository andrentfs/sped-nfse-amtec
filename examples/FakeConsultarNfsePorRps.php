<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\NFSeAmtec\Tools;
use NFePHP\NFSeAmtec\Common\Soap\SoapFake;
use NFePHP\NFSeAmtec\Common\FakePretty;

try {
    
    $config = [
        'cnpj' => '99999999000191',
        'im' => '1733160024',
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

    $numero = 123456;
    $serie = 'UNICA';
    $tipo = 1;

    $response = $tools->consultarNfsePorRps($numero, $serie, $tipo);
    
    echo FakePretty::prettyPrint($response, '');
 
} catch (\Exception $e) {
    echo $e->getMessage();
}

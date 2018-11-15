# sped-nfse-amtec

Esse "padrão" se é que pode ser chamado assim. É uma ABRASF 2.0 (modificado)

Atende apenas o Municipio de Goiânia - GO

- Goiania GO
- IBGE: 5208707
- SIAF: 9373
- Padrão: AMTEC (Abrasf 2.0 modificado)
- SOAP Version: 1.2

- URL Única: https://nfse.goiania.go.gov.br/ws/nfse.asmx
- xmlns: http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd

[![Latest Stable Version][ico-stable]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

Este pacote é aderente com os [PSR-1], [PSR-2] e [PSR-4]. Se você observar negligências de conformidade, por favor envie um patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

Não deixe de se cadastrar no [grupo de discussão do NFePHP](http://groups.google.com/group/nfephp) para acompanhar o desenvolvimento e participar das discussões e tirar duvidas!



## Instalação 

Este pacote está listado no Packgist foi desenvolvido para uso do Composer, portanto não será explicitada nenhuma alternativa de instalação.

E deve ser instalado com:
```
composer require nfephp-org/sped-nfse-amtec:dev-master --prefer-dist
```

Ou ainda alterando o composer.json do seu aplicativo inserindo:
```
"require": {
    "nfephp-org/sped-nfse-amtec" : "dev-master"
}
```

Para utilizar o pacote em desenvolvimento (branch master) deve ser instalado com:
```
composer require nfephp-org/sped-nfe:dev-master --prefer-dist
```

Ou ainda alterando o composer.json do seu aplicativo inserindo:
```
"require": {
    "nfephp-org/sped-nfse-amtec" : "dev-master"
}
```

> NOTA: Ao utilizar este pacote na versão em desenvolvimento não se esqueça de alterar o composer.json da sua aplicação para aceitar pacotes em desenvolvimento, alterando a propriedade "minimum-stability" de "stable" para "dev".
```
"minimum-stability": "dev"
```

> **ATENÇÃO: O Certificado Digital deve ser emitido para o CNPJ informado no Cadastro de Atividades Econômicas do Prestador da Prefeitura, NÃO sendo aceito Certificado emitido para CNPJ RAIZ**

> NOTA: Não há documentação oficial disponível. O suporte pela pagina da prefeitura é inexistente.

> Obs.: Informações Tributárias e Operacionais do sistema NFS-e devem ser tratadas junto à GIOF - Gerência de Inteligência e Operações Fiscais, telefone 62 3524-4040. O e-mail suporte.nfse@goiania.go.gov.br é destinado apenas aos desenvolvedores no auxílio à implementação do web service e possui o prazo médio de resposta de 1 dia.

## Agradecimentos 

Devemos agradecer ao pessoal do [ACBR](https://www.projetoacbr.com.br/), pois com as informações fornecidas pelos colegas no forum do ACBR que foi possivel resolver os erros e entender o funcionamento desse "modelo".

- GUTOPMC
- Julio Chaves
 
Link com algumas informações fornecidas pelo colega GUTOPMC : https://docs.google.com/document/d/1B6L11ZGv2iXMfxCtIJxgzLaDCyeF-tCJ82ELysnJaTs/edit?pli=1

## Métodos

Existem apenas DOIS métodos no webservice:

### GerarNfse (onde pode ser enviado APENAS um RPS por vez)

### ConsultarNfseRps

> Nenhuma outra função do modelo ABRASF está disponivel por webservice, então caso se deseje um cancelamento por exemplo isso deverá ser feito diretamente na pagina da Prefeitura.

Além desses métodos do webservice também existe uma pagina onde é possivel obter um HTML formatado para impressão da NFSe.

http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=1300687&nota=370&verificador=MB94-C3ZA


## GERAÇÃO SÍNCRONA DE UMA NFS-e (GerarNfse):

Este documento é provisório, de uso restrito e contém instruções para teste de utilização do web service da Prefeitura de Goiânia.

O Web Service é baseado no modelo nacional de NFS-e, versão 2.0 da ABRASF, com adequações comentadas abaixo e descritas no esquema XSD informado. Para obter a documentação do modelo conceitual e manual de integração da ABRASF, consulte http://www.abrasf.org.br, em Temas Técnicos e escolha NFS-e.

A geração síncrona retorna o XML dos dados da nota gerada na mesma conexão da solicitação da geração.

**ATENÇÃO: Não haverá geração de notas em lotes.**
 
No link abaixo existe um XML exemplo básico de solicitação de GERAÇÃO SÍNCRONA DE UMA NFS-e (GerarNfse).

[GerarNFse](examples/gerarnfse.xml)

### Ambientes (Produção e Homologação)

O ambiente do web service **é apenas de produção**, onde o banco de dados utilizado é sempre o de produção.

A utilização do web service pode ser em modo TESTE ou modo PRODUÇÃO.

O endereço do web service é o mesmo para os dois modos.

**Inicialmente todos os Prestadores estão em modo TESTE.**

Em modo TESTE todas as validações e críticas são reais, porém, nenhuma Nota é gerada e, caso não existam críticas, sempre um mesmo XML com dados de uma Nota Fictícia é retornado. Em modo PRODUÇÃO, após as validações e críticas, a Nota Fiscal é efetivamente gerada e o XML com os dados da Nota gerada é retornado.

Para a utilização do web service em modo TESTE não é necessário Processo Administrativo ou qualquer autorização ou senha.

Para a utilização do web service em modo PRODUÇÃO o Processo Administrativo de autorização de emissão de NFS-e junto à Secretaria de Finanças deve ter sido concluído.

Note que este é o Processo Administrativo que qualquer Prestador normalmente passa para começar a emitir NFS-e, seja pelo site ou pelo web service.

Não existe processo administrativo para a alteração do modo do web service. **Apenas um e-mail deve ser enviado solicitando esta alteração.**

Após finalizados os testes e concluído o Processo de autorização na Secretaria de Finanças, o Prestador deve solicitar através do e-mail suporte.nfse@goiania.go.gov.br a alteração da utilização do web service para modo PRODUÇÃO, informando a Inscrição Municipal e Razão Social da empresa. O prazo médio para atendimento é de 1 dia.
 
Endereço do Web Service:
https://nfse.goiania.go.gov.br/ws/nfse.asmx
 
Interfaces do Web Service (WSDL):
https://nfse.goiania.go.gov.br/ws/nfse.asmx?wsdl
 
Schema XSD: 
https://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd
 
Namespace do XSD:
http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd
 
Adequações do esquema:

- As adequações não acrescentam ou excluem elementos no esquema original da ABRASF versão 2.0.

- As adequações apenas alteram a obrigatoriedade ou não de envio de informações para a geração da nota.

- As adequações estão documentadas em comentários inseridos antes de cada elemento no Schema XSD.

> NOTA: as alegações acima ou estão incorretas ou incompletas e pouco ajudam.
 
### Resumo das adequações:

elemento tcIdentificacaoPrestador/tcCpfCnpj - OBRIGATÓRIO

elemento tcIdentificacaoPrestador/tsInscricaoMunicipal - OBRIGATÓRIO

elemento tcValoresDeclaracaoServico/ValorIss - NÃO DEVE SER ENVIADO

elemento tcValoresDeclaracaoServico/DescontoCondicionado - NÃO DEVE SER ENVIADO

elemento tcValoresNfse/ValorLiquidoNfse (Layout alterado para minOccurs="0") - NÃO SERÁ RETORNADO

elemento tcDadosServico/IssRetido (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO

elemento tcDadosServico/ResponsavelRetencao - NÃO DEVE SER ENVIADO

elemento tcDadosServico/ItemListaServico (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO

elemento tcDadosServico/CodigoCnae - NÃO DEVE SER ENVIADO

elemento tcDadosServico/CodigoTributacaoMunicipio - OBRIGATÓRIO

elemento tcDadosServico/ExigibilidadeISS (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO

elemento tcDadosServico/MunicipioIncidencia - NÃO DEVE SER ENVIADO
 
elemento tcInfDeclaracaoPrestacaoServico/Competencia (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO

elemento tcInfDeclaracaoPrestacaoServico/OptanteSimplesNacional  (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO

elemento tcInfDeclaracaoPrestacaoServico/IncentivoFiscal (Layout alterado para minOccurs="0") - NÃO DEVE SER ENVIADO
 
elemento tcInfNfse/EnderecoPrestadorServico (Layout alterado para minOccurs="0") - NÃO SERÁ RETORNADO NO XML RESPOSTA

elemento tcInfNfse/OrgaoGerador (Layout alterado para minOccurs="0") - NÃO SERÁ RETORNADO NO XML RESPOSTA

elemento tcInfNfse/DeclaracaoPrestacaoServico (Layout alterado para minOccurs="0") - NÃO SERÁ RETORNADO NO XML RESPOSTA
 
### OBSERVAÇÕES IMPORTANTES:

- Para emitir uma nota fiscal para pessoa física que não informou o CPF, utilize a seguinte identificação do tomador: “<IdentificacaoTomador><CpfCnpj><Cpf>00000000000</Cpf></CpfCnpj></IdentificacaoTomador>”.
- Para emitir uma nota fiscal para pessoa física que não informou o endereço, não informe a tag <Endereco>.
- O campo Razão Social do Tomador é sempre obrigatório e, no caso de Tomador do tipo pessoa física não informado, pode-se preenchê-lo com texto padrão (Ex.: “TOMADOR NAO INFORMADO”).
- A tag alíquota será obrigatória apenas quando o Prestador é enquadrado no Simples Nacional. Nas demais situações essa informação não é obrigatória e será gerada pelo sistema.
- As quebras de linha na tag \<Discriminacao\> devem ser representadas pelo conjunto "\s\n", conforme modelo ABRASF versão 2.0.
- Os caracteres permitidos atualmente na tag \<Discriminacao\> são os seguintes, dentro das aspas: "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&$%()/+-.,;:=* ".
- A tabela de municípios a ser utilizada é a mesma em uso atualmente na DMS (Declaração Mensal de Serviços), REST (Relação de Serviços de Terceiros) e MAPA BANCÁRIO na Prefeitura de Goiânia.
- A tabela de municípios contém diferenças em relação à tabela de municípios do IBGE [TABELA](examples/Municipios_SETEC_22.04.2013.txt).
- O código da tabela de municípios no XML de envio deve ser preenchido com zeros à esquerda para totalizar as 7 posições do layout ABRASF versão 2.0.
- A Prefeitura de Goiânia utiliza a tag \<CodigoTributacaoMunicipio\> para definir a Atividade Econômica à qual pertence o serviço prestado discriminado na nota.
- A tag \<CodigoTributacaoMunicipio\> deve conter um dos códigos de atividade econômica prestacional existentes no Cadastro do Prestador na Prefeitura de Goiânia.
- Os Códigos de Atividade Econômica possuem 9 dígitos, são definidos por tabela da Prefeitura e podem ser consultados nos Sistemas DMS, REST ou NFS-e no portal da Prefeitura na Internet, na opção "Consulta Dados Cadastrais".
- Um nota pode conter mais de um serviço desde que pertencentes ao mesmo código de atividade econômica (CodigoTributacaoMunicipio).


### Instruções para VISUALIZAÇÃO DA NFS-e:

O link abaixo retorna a NFS-e formatada em HTML para visualização e impressão:
  
http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=Inscricao_municipal&nota=Numero_da_nota&verificador=Codigo_de_verificacao

Os campos "Numero da nota" e "Codigo de verificacao" são retornados no XML resposta de cada nota gerada.

O link também pode ser apenas enviado ao tomador por e-mail e ele mesmo imprimir a nota.

Opcionalmente, o Prestador pode carregar uma imagem da sua logomarca através do sistema NFS-e no portal da Prefeitura na Internet.

Essa é a única forma permitida de visualização e impressão das notas geradas. 

**A formatação da nota pela aplicação do prestador não é permitida.**

Por exemplo, a nota fictícia retornada nos testes de geração pode ser visualizada no link abaixo:

http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=1300687&nota=370&verificador=MB94-C3ZA


## CONSULTA SÍNCRONA DE UMA NFS-e POR RPS (ConsultarNfseRps):

Este é um documento provisório, de uso restrito e contém instruções para teste de web service com parceiros da Prefeitura de Goiânia.
 
O web service é baseado no modelo nacional de NFS-e, versão 2.0 da ABRASF, com adequações descritas no esquema XSD informado abaixo.

Para obter a documentação do modelo conceitual e manual de integração da ABRASF, consulte http://www.abrasf.org.br, em Temas Técnicos escolha NFS-e.
 
No link abaixo existe um XML exemplo básico de solicitação de CONSULTA SÍNCRONA DE UMA NFS-e POR RPS (ConsultarNfseRps).

[ConsultaNfseRps](examples/consulta_nfse_rps.xml)

As solicitações serão processadas em ambiente de produção, porém, em modo TESTE.

Caso não existam críticas, será retornado um XML resposta idêntico ao da geração de nota.

O XML envio da consulta não deve ser assinado, porém, o certificado digital deve ser adicionado à chamada do serviço.

O certificado aceito nas transações deve ser emitido por uma Autoridade Certificadora credenciada pela ICP-Brasil, no padrão e-CNPJ ou e-CPF e do tipo A1 ou A3.

Após a finalização da fase de testes e solicitada a adesão à NFS-e junto à Secretaria de Finanças, solicite-nos a mudança do modo TESTE para o modo PRODUÇÃO.


## DÚVIDAS FREQUENTES


*P: Como realizo a alteração do modo do web service para PRODUÇÃO?*

R: Após finalizados os testes e concluído o Processo de autorização na Secretaria de Finanças, o Prestador deve solicitar através do e-mail suporte.nfse@goiania.go.gov.br a alteração da utilização do web service para modo PRODUÇÃO, informando a Inscrição Municipal e Razão Social da empresa.


*P: Como posso verificar se o Prestador está em modo TESTE ou modo PRODUÇÃO?*

R: Inicialmente, todos os Prestadores estão em modo TESTE. O modo do Prestador só é alterado mediante solicitação do mesmo. Caso você esteja recebendo como retorno a nota fictícia de número 370, você está em modo TESTE.


*P: O Prestador já está em modo PRODUÇÃO, porém necessito realizar testes na geração de notas. Como proceder?*

R: Preencha a tag \<serie\> do XML com o valor "TESTE" ao consumir o serviço de geração de notas. Assim, o sistema se comportará como se o Prestador estivesse em modo TESTE para esta solicitação em específico.


*P: Como proceder a substituição de notas?*

R: Através do site na NFS-e (http://goiania.go.gov.br/nfse/), nos termos lá descritos, ou via Processo Administrativo junto à Secretaria de Finanças. Não existe substituição via web service.


*P: Como proceder o cancelamento de notas?*

R: Através de Processo Administrativo junto à Secretaria de Finanças. Não existe cancelamento via web service.


*P: Estou recebendo erros relativos ao protocolo SOAP. Como proceder?*

R: Consulte os endereços:

https://nfse.goiania.go.gov.br/ws/nfse.asmx?op=GerarNfse

https://nfse.goiania.go.gov.br/ws/nfse.asmx?op=ConsultarNfseRps


*P: Como adicionar dados ao campo "Informações Adicionais" via web service?*

R: Só é possível preencher este campo da nota fiscal quando gerada através do site da NFS-e. Não há como adicionar dados a este campo ao gerar uma nota via web service. Seguindo os padrões da ABRASF, este campo é apenas de leitura, acessível apenas quando uma nota é consultada. Caso o Prestador deseje adicionar informações adicionais à nota via web service, recomendamos que utilize o campo "Discriminação" para este fim.

*P: É necessário a utilização do Certificado Digital / Assinatura Digital quando o Prestador está em modo TESTE?*

R: Sim.

*P: É possível, quando em desenvolvimento, utilizar-se de um Certificado Digital alternativo ao do Prestador?*

R: Sim, apenas temporariamente e quando o Prestador encontra-se em modo TESTE. O Certificado Digital deve ser válido e estar dentro das especificações descritas nas instruções de integração. Realize esta solicitação através do e-mail suporte.nfse@goiania.go.gov.br.

*P: Existe uma numeração diferente para as notas fiscais geradas via web service?*

R: Não. A numeração das notas fiscais eletrônicas seguem uma sequência única. Seja a geração realizada pelo site da NFS-e ou via web service, o sistema pegará o próximo número de nota para aquele Prestador.

*P: O número do RPS deve obrigatoriamente acompanhar o número da nota fiscal?*

R: Não. RPS e número de nota fiscal são numerações independentes. O número da nota é sequencial, controlado pela Prefeitura, e sempre continuará na mesma sequência única. O número do RPS é de controle do Prestador e deve ser único. Não é permitido repetir um número de RPS. O número de RPS não precisa ser necessariamente sequencial. Cada número de RPS é associado a um número de nota fiscal, não necessitando ambos serem iguais.

*P: Existem registros duplicados na Tabela de Municípios? Como a Tabela de Municípios funciona?*

R: Não existem registros duplicados na Tabela de Municípios.

Todo registro cujo código é terminado com "00" se refere a um Município. Todo código terminado com uma numeração diferente de "00" se refere a um Distrito de um Município cujo código começa com a mesma numeração e termina com "00".

Exemplo:

O registro abaixo se refere ao Município de Bom Jesus de Goiás. Sabemos disso pois o código deste registro (039200) termina com "00".

039200;BOM JESUS     	                           ;GO

O registro abaixo se refere a um Distrito chamado Bom Jesus. Sabemos disso pois o código desse registro (024602) termina com "02", que é diferente de "00".

Ao pegarmos a primeira parte do código que precede os 2 últimos números (0246) e acrescentarmos "00" (024600) encontramos o código do Município de Ceres.

Logo este Bom Jesus é um Distrito do Município de Ceres, uma localidade diferente do Município de Bom Jesus.

024602;BOM JESUS                                	;GO

024600;CERES                                    	;GO


### INCONSISTÊNCIAS QUE COSTUMAM GERAR DÚVIDAS


**Código: L002**

Mensagem: CPF ou CNPJ da assinatura digital não confere com o CPF ou CNPJ do prestador dos serviços.

Resolução:

O CPF/CNPJ do Certificado Digital utilizado para assinar o XML não confere com o CPF/CNPJ do Prestador no XML. O CPF/CNPJ do Certificado Digital deve ser IDÊNTICO ao CPF/CNPJ constante nos dados do Prestador do XML e IDÊNTICO ao CPF/CNPJ constante no Cadastro do Prestador na Prefeitura de Goiânia. Não é permitido o uso de CNPJ raiz se este não for EXATAMENTE o mesmo CNPJ constante no Cadastro da Prefeitura. Por este motivo não é possível emitir notas fiscais para filiais utilizando Certificado Digital contendo o CNPJ raiz das matrizes quando estes não são EXATAMENTE iguais.


**Código: L999**

Mensagem: ATIVIDADE INFORMADA INEXISTENTE NO SEU CADASTRO NA PREFEITURA

Resolução:

A Prefeitura de Goiânia utiliza a tag CodigoTributacaoMunicipio para definir a Atividade Econômica à qual pertence o serviço prestado discriminado na nota.

A tag CodigoTributacaoMunicipio deve conter um dos códigos de atividade econômica prestacional existentes no Cadastro do Prestador na Prefeitura de Goiânia.

Os Códigos de Atividade Econômica possuem 9 dígitos, são definidos por tabela da Prefeitura e podem ser consultados nos Sistemas DMS, REST ou NFS-e no portal da Prefeitura na Internet, na opção "Consulta Dados Cadastrais".

Um nota pode conter mais de um serviço desde que pertencentes ao mesmo código de atividade econômica (CodigoTributacaoMunicipio).


**Código: L999**

Mensagem: CODIGO DO MUNICIPIO NAO ENCONTRADO

Resolução:

- A tabela de municípios a ser utilizada é a mesma em uso atualmente na DMS (Declaração Mensal de Serviços), REST (Relação de Serviços de Terceiros) e MAPA BANCÁRIO na Prefeitura de Goiânia.
- A tabela de municípios contém diferenças em relação à tabela de municípios do IBGE.
- O código da tabela de municípios no XML de envio deve ser preenchido com zeros à esquerda para totalizar as 7 posições do layout ABRASF versão 2.0.


**Código: E160**

Mensagem: Arquivo em desacordo com o XML Schema.

Resolução:

Existem inconsistências em relação ao Schema XSD. Existem aplicações que realizam a checagem do XML com o XSD e aponta as inconsistências existentes, muitas delas gratuitas (Exemplo: http://www.corefiling.com/opensource/schemaValidate.html). Você também pode utilizar os próprios recursos da linguagem utilizada na implementação para isso.

Use os exemplos anexados às instruções de integração como base inicial de referência para a implementação.

**Código: E172**

Mensagem: Arquivo enviado com erro na assinatura.

Resolução:

A tag que deve ser assinada no documento XML de geração de nota fiscal é a primeira tag \<Rps\>, que vem logo após a tag \<GerarNfseEnvio\>. Geralmente esse erro ocorre quando uma tag diferente é assinada.

```xml
<Rps>
    <InfDeclaracaoPrestacaoServico xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd">
        <Rps Id="rps1F">
            <IdentificacaoRps>
                <Numero>1</Numero>
                <Serie>F</Serie>
                <Tipo>1</Tipo>
            </IdentificacaoRps>
            <DataEmissao>2011-08-12T00:00:00</DataEmissao>
            <Status>1</Status>
        </Rps>
        <Servico>
        ...
```
No exemplo acima a tag a ser assinada é a identificada com o Id="rps1F"

A tag \<InfDeclaracaoPrestacaoServico\> deve conter também o namespace xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd", caso contrario haverá erro de assinatura.

## [SOAP Envelope ConsultaNfseRps](examples/envelope_consulta_nfse_rps.xml)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <ConsultarNfseRps xmlns="http://nfse.goiania.go.gov.br/ws/">
      <ArquivoXML><![CDATA[<ConsultarNfseRpsEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd"><IdentificacaoRps><Numero>123456</Numero><Serie>A</Serie><Tipo>1</Tipo></IdentificacaoRps><Prestador><CpfCnpj><Cnpj>99999999000191</Cnpj></CpfCnpj><InscricaoMunicipal>1733160024</InscricaoMunicipal></Prestador></ConsultarNfseRpsEnvio>]]></ArquivoXML>
    </ConsultarNfseRps>
  </soap12:Body>
</soap12:Envelope>
```

## [SOAP Envelope ConsultaNfseRps](examples/envelope_gerarnfse.xml)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <GerarNfse xmlns="http://nfse.goiania.go.gov.br/ws/">
      <ArquivoXML><![CDATA[<GerarNfseEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd"><Rps><InfDeclaracaoPrestacaoServico xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd"><Rps Id="rps1F"><IdentificacaoRps><Numero>1</Numero><Serie>F</Serie><Tipo>1</Tipo></IdentificacaoRps><DataEmissao>2011-08-12T00:00:00</DataEmissao><Status>1</Status></Rps><Servico><Valores><ValorServicos>6000.00</ValorServicos><ValorPis>40.50</ValorPis><ValorCofins>40.50</ValorCofins><ValorInss>10.50</ValorInss><ValorCsll>10.50</ValorCsll><DescontoIncondicionado>500.00</DescontoIncondicionado></Valores><CodigoTributacaoMunicipio>631190000</CodigoTributacaoMunicipio><Discriminacao>TESTE DE WEBSERVICE SABETUDO</Discriminacao><CodigoMunicipio>2530000</CodigoMunicipio></Servico><Prestador><CpfCnpj><Cpf>24329550130</Cpf></CpfCnpj><InscricaoMunicipal>1442678</InscricaoMunicipal></Prestador><Tomador><IdentificacaoTomador><CpfCnpj><Cpf>28222148168</Cpf></CpfCnpj><InscricaoMunicipal>1708</InscricaoMunicipal></IdentificacaoTomador><RazaoSocial>LUIZ AUGUSTO MARINHO NOLETO</RazaoSocial><Endereco><Endereco>RUA 3</Endereco><Numero>1003</Numero><Complemento>1003</Complemento><Bairro>CENTRO</Bairro><CodigoMunicipio>5208707</CodigoMunicipio><Uf>GO</Uf></Endereco></Tomador></InfDeclaracaoPrestacaoServico><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI="#rps1F"><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>QYA7+yAGArVZrQU9joIj7i6ueUY=</DigestValue></Reference></SignedInfo><SignatureValue>Oo0FSgAjwiDtFiMr8mqjYsMIHSB4oWnQq932xb1XQ7Jysa2J2f9IUzuQ1CCNw9QlgLg8CX3evz7+FOjSIwqIg5cE9BDlsh1e08w0BieurkhrYHRMtqBfbhUQzXHNJJU/F0+V5dsSLQ0qrK/DclegbLQY7yxLfn0pT9RbGQ6OIb8=</SignatureValue><KeyInfo><X509Data><X509Certificate>MIIEqzCCA5OgAwIBAgIDMTg4MA0GCSqGSIb3DQEBBQUAMIGSMQswCQYDVQQGEwJCUjELMAkGA1UECBMCUlMxFTATBgNVBAcTDFBvcnRvIEFsZWdyZTEdMBsGA1UEChMUVGVzdGUgUHJvamV0byBORmUgUlMxHTAbBgNVBAsTFFRlc3RlIFByb2pldG8gTkZlIFJTMSEwHwYDVQQDExhORmUgLSBBQyBJbnRlcm1lZGlhcmlhIDEwHhcNMDkwNTIyMTcwNzAzWhcNMTAxMDAyMTcwNzAzWjCBnjELMAkGA1UECBMCUlMxHTAbBgNVBAsTFFRlc3RlIFByb2pldG8gTkZlIFJTMR0wGwYDVQQKExRUZXN0ZSBQcm9qZXRvIE5GZSBSUzEVMBMGA1UEBxMMUE9SVE8gQUxFR1JFMQswCQYDVQQGEwJCUjEtMCsGA1UEAxMkTkZlIC0gQXNzb2NpYWNhbyBORi1lOjk5OTk5MDkwOTEwMjcwMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCx1O/e1Q+xh+wCoxa4pr/5aEFt2dEX9iBJyYu/2a78emtorZKbWeyK435SRTbHxHSjqe1sWtIhXBaFa2dHiukT1WJyoAcXwB1GtxjT2VVESQGtRiujMa+opus6dufJJl7RslAjqN/ZPxcBXaezt0nHvnUB/uB1K8WT9G7ES0V17wIDAQABo4IBfjCCAXowIgYDVR0jAQEABBgwFoAUPT5TqhNWAm+ZpcVsvB7malDBjEQwDwYDVR0TAQH/BAUwAwEBADAPBgNVHQ8BAf8EBQMDAOAAMAwGA1UdIAEBAAQCMAAwgawGA1UdEQEBAASBoTCBnqA4BgVgTAEDBKAvBC0yMjA4MTk3Nzk5OTk5OTk5OTk5MDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDCgEgYFYEwBAwKgCQQHREZULU5GZaAZBgVgTAEDA6AQBA45OTk5OTA5MDkxMDI3MKAXBgVgTAEDB6AOBAwwMDAwMDAwMDAwMDCBGmRmdC1uZmVAcHJvY2VyZ3MucnMuZ292LmJyMCAGA1UdJQEB/wQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDBTBgNVHR8BAQAESTBHMEWgQ6BBhj9odHRwOi8vbmZlY2VydGlmaWNhZG8uc2VmYXoucnMuZ292LmJyL0xDUi9BQ0ludGVybWVkaWFyaWEzOC5jcmwwDQYJKoZIhvcNAQEFBQADggEBAJFytXuiS02eJO0iMQr/Hi+Ox7/vYiPewiDL7s5EwO8A9jKx9G2Baz0KEjcdaeZk9a2NzDEgX9zboPxhw0RkWahVCP2xvRFWswDIa2WRUT/LHTEuTeKCJ0iF/um/kYM8PmWxPsDWzvsCCRp146lc0lz9LGm5ruPVYPZ/7DAoimUk3bdCMW/rzkVYg7iitxHrhklxH7YWQHUwbcqPt7Jv0RJxclc1MhQlV2eM2MO1iIlk8Eti86dRrJVoicR1bwc6/YDqDp4PFONTi1ddewRu6elGS74AzCcNYRSVTINYiZLpBZO0uivrnTEnsFguVnNtWb9MAHGt3tkR0gAVs6S0fm8=</X509Certificate></X509Data></KeyInfo></Signature></Rps></GerarNfseEnvio>]]></ArquivoXML>
    </GerarNfse>
  </soap12:Body>
</soap12:Envelope>
```

[ico-stable]: https://poser.pugx.org/nfephp-org/sped-nfse-amtec/version
[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nfephp-org/sped-nfse-amtec/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-nfse-amtec.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square
[ico-gitter]: https://img.shields.io/badge/GITTER-4%20users%20online-green.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/nfephp-org/sped-nfse-amtec
[link-travis]: https://travis-ci.org/nfephp-org/sped-nfse-amtec
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-nfse-amtec/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-nfse-amtec
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-nfse-amtec
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-nfse-amtec/issues
[link-forks]: https://github.com/nfephp-org/sped-nfse-amtec/network
[link-stars]: https://github.com/nfephp-org/sped-nfse-amtec/stargazers


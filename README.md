# sped-nfse-amtec

## Esse "padrão" se é que pode ser chamado assim. É uma ABRASF 2.0 (modificado)

## Atende apenas o Municipio de Goiânia - GO

## ATENÇÃO: Não existe diferença entre homologação e produção, isso não pode ser controlado pela API, mas apenas pela Prefeitura.

- Goiania GO
- IBGE: 5208707
- SIAF: 9373
- Padrão: AMTEC (Abrasf 2.0 modificado)
- SOAP Version: 1.2

- URL Única: https://nfse.goiania.go.gov.br/ws/nfse.asmx
- xmlns: http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd

> **ATENÇÃO: O Certificado Digital deve ser emitido para o CNPJ informado no Cadastro de Atividades Econômicas do Prestador da Prefeitura, NÃO sendo aceito Certificado emitido para CNPJ RAIZ**

> NOTA: Não há documentação oficial disponível. O suporte pela pagina da prefeitura é inexistente.

Link com Informações coletadas : https://docs.google.com/document/d/1B6L11ZGv2iXMfxCtIJxgzLaDCyeF-tCJ82ELysnJaTs/edit?pli=1

## Métodos

Existem apenas DOIS métodos no webservice:

### GerarNfse (onde pode ser enviado APENAS um RPS por vez)

### ConsultarNfseRps

> Nenhuma outra função do modelo ABRASF está disponivel por webservice, então caso se deseje um cancelamento por exemplo isso deverá ser feito diretamente na pagina da Prefeitura.


O web service da NFS-e de Goiânia disponibiliza 3 serviços:

Geração síncrona de uma NFS-e
Visualização de uma NFS-e (Formatada em HTML)
Consulta síncrona de uma NFS-e pelo RPS
 
Não é disponibilizado o cancelamento ou a substituição de NFS-e via web service. Substituição e Cancelamento são realizáveis através do site da NFS-e, nos termos lá descritos, ou via Processo Administrativo junto à Secretaria de Finanças.

Obs.: Informações Tributárias e Operacionais do sistema NFS-e devem ser tratadas junto à GIOF - Gerência de Inteligência e Operações Fiscais, telefone 62 3524-4040. O e-mail suporte.nfse@goiania.go.gov.br é destinado apenas aos desenvolvedores no auxílio à implementação do web service e possui o prazo médio de resposta de 1 dia.

Instruções para o serviço GERAÇÃO SÍNCRONA DE UMA NFS-e (GerarNfse):

Este documento é provisório, de uso restrito e contém instruções para teste de utilização do web service da Prefeitura de Goiânia.

O Web Service é baseado no modelo nacional de NFS-e, versão 2.0 da ABRASF, com adequações comentadas abaixo e descritas no esquema XSD informado. Para obter a documentação do modelo conceitual e manual de integração da ABRASF, consulte http://www.abrasf.org.br, em Temas Técnicos e escolha NFS-e.

A geração síncrona retorna o XML dos dados da nota gerada na mesma conexão da solicitação da geração.

ATENÇÃO: Não haverá geração de notas em lotes.
 
No link abaixo existe um XML exemplo básico de solicitação de GERAÇÃO SÍNCRONA DE UMA NFS-e (GerarNfse).

https://drive.google.com/file/d/0B-E5V-N1GV7lSHZDQWJFd2NCSmc/edit?usp=sharing

O Certificado Digital aceito nas transações deve ser emitido por Autoridade Certificadora credenciada pela ICP-Brasil, padrão e-CNPJ ou e-CPF e do tipo A1 ou A3. O Certificado Digital deve ser emitido para o CNPJ informado no Cadastro de Atividades Econômicas do Prestador da Prefeitura, não sendo aceito Certificado emitido para CNPJ raiz.

O ambiente do web service é apenas de produção onde o banco de dados utilizado é sempre o de produção.
A utilização do web service pode ser em modo TESTE ou modo PRODUÇÃO.
O endereço do web service é o mesmo para os dois modos.

Inicialmente todos os Prestadores estão em modo TESTE.

Em modo TESTE todas as validações e críticas são reais, porém, nenhuma Nota é gerada e, caso não existam críticas, sempre um mesmo XML com dados de uma Nota Fictícia é retornado. Em modo PRODUÇÃO, após as validações e críticas, a Nota Fiscal é efetivamente gerada e o XML com os dados da Nota gerada é retornado.

Para a utilização do web service em modo TESTE não é necessário Processo Administrativo ou qualquer autorização ou senha.

Para a utilização do web service em modo PRODUÇÃO o Processo Administrativo de autorização de emissão de NFS-e junto à Secretaria de Finanças deve ter sido concluído. Note que este é o Processo Administrativo que qualquer Prestador normalmente passa para começar a emitir NFS-e, seja pelo site ou pelo web service. Não existe processo administrativo para a alteração do modo do web service. Apenas um e-mail deve ser enviado solicitando esta alteração.

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
As adequações não acrescentam ou excluem elementos no esquema original da ABRASF versão 2.0.
As adequações apenas alteram a obrigatoriedade ou não de envio de informações para a geração da nota.
As adequações estão documentadas em comentários inseridos antes de cada elemento no Schema XSD.
 
Resumo das adequações:

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
 
OBSERVAÇÕES IMPORTANTES:

- Para emitir uma nota fiscal para pessoa física que não informou o CPF, utilize a seguinte identificação do tomador: “<IdentificacaoTomador><CpfCnpj><Cpf>00000000000</Cpf></CpfCnpj></IdentificacaoTomador>”.
- Para emitir uma nota fiscal para pessoa física que não informou o endereço, não informe a tag <Endereco>.
- O campo Razão Social do Tomador é sempre obrigatório e, no caso de Tomador do tipo pessoa física não informado, pode-se preenchê-lo com texto padrão (Ex.: “Tomador não informado”).

- A tag alíquota será obrigatória apenas quando o Prestador é enquadrado no Simples Nacional. Nas demais situações essa informação não é obrigatória e será gerada pelo sistema.

- As quebras de linha na tag <Discriminacao> devem ser representadas pelo conjunto "\s\n", conforme modelo ABRASF versão 2.0.
- Os caracteres permitidos atualmente na tag <Discriminacao> são os seguintes, dentro das aspas: "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&$%()/+-.,;:=* ".

- A tabela de municípios a ser utilizada é a mesma em uso atualmente na DMS (Declaração Mensal de Serviços), REST (Relação de Serviços de Terceiros) e MAPA BANCÁRIO na Prefeitura de Goiânia.
- A tabela de municípios contém diferenças em relação à tabela de municípios do IBGE.
- O código da tabela de municípios no XML de envio deve ser preenchido com zeros à esquerda para totalizar as 7 posições do layout ABRASF versão 2.0.
- Download da tabela de municípios: http://www2.goiania.go.gov.br/sistemas/sress/Docs/Municipio.zip 

- A Prefeitura de Goiânia utiliza a tag <CodigoTributacaoMunicipio> para definir a Atividade Econômica à qual pertence o serviço prestado discriminado na nota.
- A tag <CodigoTributacaoMunicipio> deve conter um dos códigos de atividade econômica prestacional existentes no Cadastro do Prestador na Prefeitura de Goiânia.
- Os Códigos de Atividade Econômica possuem 9 dígitos, são definidos por tabela da Prefeitura e podem ser consultados nos Sistemas DMS, REST ou NFS-e no portal da Prefeitura na Internet, na opção "Consulta Dados Cadastrais".
- Um nota pode conter mais de um serviço desde que pertencentes ao mesmo código de atividade econômica (CodigoTributacaoMunicipio).


Instruções para VISUALIZAÇÃO DA NFS-e:

O link abaixo retorna a NFS-e formatada em HTML para visualização e impressão:
  
http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=<Inscricao_municipal>&nota=<Numero_da_nota>&verificador=<Codigo_de_verificacao>

Os campos "Numero da nota" e "Codigo de verificacao" são retornados no XML resposta de cada nota gerada.

O link também pode ser apenas enviado ao tomador por e-mail e ele mesmo imprimir a nota.

Opcionalmente, o Prestador pode carregar uma imagem da sua logomarca através do sistema NFS-e no portal da Prefeitura na Internet.

Essa é a única forma permitida de visualização e impressão das notas geradas. A formatação da nota pela aplicação do prestador não é permitida.

Por exemplo, a nota fictícia retornada nos testes de geração pode ser visualizada no link abaixo:
http://www2.goiania.go.gov.br/sistemas/snfse/asp/snfse00200w0.asp?inscricao=1300687&nota=370&verificador=MB94-C3ZA


Instruções para o serviço CONSULTA SÍNCRONA DE UMA NFS-e POR RPS (ConsultarNfseRps):

Este é um documento provisório, de uso restrito e contém instruções para teste de web service com parceiros da Prefeitura de Goiânia.
 
O web service é baseado no modelo nacional de NFS-e, versão 2.0 da ABRASF, com adequações descritas no esquema XSD informado abaixo.
Para obter a documentação do modelo conceitual e manual de integração da ABRASF, consulte http://www.abrasf.org.br, em Temas Técnicos escolha NFS-e.
 
No link abaixo existe um XML exemplo básico de solicitação de CONSULTA SÍNCRONA DE UMA NFS-e POR RPS (ConsultarNfseRps).

https://drive.google.com/file/d/0B-E5V-N1GV7lVXA3WHN6YzlXclU/edit?usp=sharing

As solicitações serão processadas em ambiente de produção, porém, em modo TESTE.

Caso não existam críticas, será retornado um XML resposta idêntico ao da geração de nota.

O XML envio da consulta não deve ser assinado, porém, o certificado digital deve ser adicionado à chamada do serviço.   

O certificado aceito nas transações deve ser emitido por uma Autoridade Certificadora credenciada pela ICP-Brasil, no padrão e-CNPJ ou e-CPF e do tipo A1 ou A3.

Após a finalização da fase de testes e solicitada a adesão à NFS-e junto à Secretaria de Finanças, solicite-nos a mudança do modo TESTE para o modo PRODUÇÃO.


DÚVIDAS FREQUENTES


P: Como realizo a alteração do modo do web service para PRODUÇÃO?

R: Após finalizados os testes e concluído o Processo de autorização na Secretaria de Finanças, o Prestador deve solicitar através do e-mail suporte.nfse@goiania.go.gov.br a alteração da utilização do web service para modo PRODUÇÃO, informando a Inscrição Municipal e Razão Social da empresa.


P: Como posso verificar se o Prestador está em modo TESTE ou modo PRODUÇÃO?

R: Inicialmente, todos os Prestadores estão em modo TESTE. O modo do Prestador só é alterado mediante solicitação do mesmo. Caso você esteja recebendo como retorno a nota fictícia de número 370, você está em modo TESTE.


P: O Prestador já está em modo PRODUÇÃO, porém necessito realizar testes na geração de notas. Como proceder?

R: Preencha a tag <serie> do XML com o valor "TESTE" ao consumir o serviço de geração de notas. Assim, o sistema se comportará como se o Prestador estivesse em modo TESTE para esta solicitação em específico.


P: Como proceder a substituição de notas?

R: Através do site na NFS-e (http://goiania.go.gov.br/nfse/), nos termos lá descritos, ou via Processo Administrativo junto à Secretaria de Finanças. Não existe substituição via web service.


P: Como proceder o cancelamento de notas?

R: Através de Processo Administrativo junto à Secretaria de Finanças. Não existe cancelamento via web service.


P: Estou recebendo erros relativos ao protocolo SOAP. Como proceder?

R: Consulte os endereços:
https://nfse.goiania.go.gov.br/ws/nfse.asmx?op=GerarNfse
https://nfse.goiania.go.gov.br/ws/nfse.asmx?op=ConsultarNfseRps


P: Como adicionar dados ao campo "Informações Adicionais" via web service?

R: Só é possível preencher este campo da nota fiscal quando gerada através do site da NFS-e. Não há como adicionar dados a este campo ao gerar uma nota via web service. Seguindo os padrões da ABRASF, este campo é apenas de leitura, acessível apenas quando uma nota é consultada. Caso o Prestador deseje adicionar informações adicionais à nota via web service, recomendamos que utilize o campo "Discriminação" para este fim.

P: É necessário a utilização do Certificado Digital / Assinatura Digital quando o Prestador está em modo TESTE?

R: Sim.


P: É possível, quando em desenvolvimento, utilizar-se de um Certificado Digital alternativo ao do Prestador?

R: Sim, apenas temporariamente e quando o Prestador encontra-se em modo TESTE. O Certificado Digital deve ser válido e estar dentro das especificações descritas nas instruções de integração. Realize esta solicitação através do e-mail suporte.nfse@goiania.go.gov.br.


P: Existe uma numeração diferente para as notas fiscais geradas via web service?

R: Não. A numeração das notas fiscais eletrônicas seguem uma sequência única. Seja a geração realizada pelo site da NFS-e ou via web service, o sistema pegará o próximo número de nota para aquele Prestador.


P: O número do RPS deve obrigatoriamente acompanhar o número da nota fiscal?

R: Não. RPS e número de nota fiscal são numerações independentes. O número da nota é sequencial, controlado pela Prefeitura, e sempre continuará na mesma sequência única. O número do RPS é de controle do Prestador e deve ser único. Não é permitido repetir um número de RPS. O número de RPS não precisa ser necessariamente sequencial. Cada número de RPS é associado a um número de nota fiscal, não necessitando ambos serem iguais.


P: Existem registros duplicados na Tabela de Municípios? Como a Tabela de Municípios funciona?

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


INCONSISTÊNCIAS QUE COSTUMAM GERAR DÚVIDAS


Código: L002
Mensagem: CPF ou CNPJ da assinatura digital não confere com o CPF ou CNPJ do prestador dos serviços.

Resolução:

O CPF/CNPJ do Certificado Digital utilizado para assinar o XML não confere com o CPF/CNPJ do Prestador no XML. O CPF/CNPJ do Certificado Digital deve ser IDÊNTICO ao CPF/CNPJ constante nos dados do Prestador do XML e IDÊNTICO ao CPF/CNPJ constante no Cadastro do Prestador na Prefeitura de Goiânia. Não é permitido o uso de CNPJ raiz se este não for EXATAMENTE o mesmo CNPJ constante no Cadastro da Prefeitura. Por este motivo não é possível emitir notas fiscais para filiais utilizando Certificado Digital contendo o CNPJ raiz das matrizes quando estes não são EXATAMENTE iguais.


Código: L999
Mensagem: ATIVIDADE INFORMADA INEXISTENTE NO SEU CADASTRO NA PREFEITURA

Resolução:

A Prefeitura de Goiânia utiliza a tag CodigoTributacaoMunicipio para definir a Atividade Econômica à qual pertence o serviço prestado discriminado na nota.
A tag CodigoTributacaoMunicipio deve conter um dos códigos de atividade econômica prestacional existentes no Cadastro do Prestador na Prefeitura de Goiânia.
Os Códigos de Atividade Econômica possuem 9 dígitos, são definidos por tabela da Prefeitura e podem ser consultados nos Sistemas DMS, REST ou NFS-e no portal da Prefeitura na Internet, na opção "Consulta Dados Cadastrais".
Um nota pode conter mais de um serviço desde que pertencentes ao mesmo código de atividade econômica (CodigoTributacaoMunicipio).


Código: L999
Mensagem: CODIGO DO MUNICIPIO NAO ENCONTRADO
Resolução:
A tabela de municípios a ser utilizada é a mesma em uso atualmente na DMS (Declaração Mensal de Serviços), REST (Relação de Serviços de Terceiros) e MAPA BANCÁRIO na Prefeitura de Goiânia.
A tabela de municípios contém diferenças em relação à tabela de municípios do IBGE.
O código da tabela de municípios no XML de envio deve ser preenchido com zeros à esquerda para totalizar as 7 posições do layout ABRASF versão 2.0.
Download da tabela de municípios: http://www2.goiania.go.gov.br/sistemas/sress/Docs/Municipio.zip


Código: E160
Mensagem: Arquivo em desacordo com o XML Schema.
Resolução:
Existem inconsistências em relação ao Schema XSD. Existem aplicações que realizam a checagem do XML com o XSD e aponta as inconsistências existentes, muitas delas gratuitas (Exemplo: http://www.corefiling.com/opensource/schemaValidate.html). Você também pode utilizar os próprios recursos da linguagem utilizada na implementação para isso.
Use os exemplos anexados às instruções de integração como base inicial de referência para a implementação.

Código: E172
Mensagem: Arquivo enviado com erro na assinatura.
Resolução:
A tag que deve ser assinada no documento XML de geração de nota fiscal é a primeira tag <Rps>, que vem logo após a tag <GerarNfseEnvio>. Geralmente esse erro ocorre quando uma tag diferente é assinada.


## ConsultaNfseRps

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <ConsultarNfseRps xmlns="http://nfse.goiania.go.gov.br/ws/">
      <ArquivoXML><![CDATA[<ConsultarNfseRpsEnvio xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd"><IdentificacaoRps><Numero>123456</Numero><Serie>UNICA</Serie><Tipo>1</Tipo></IdentificacaoRps><Prestador><CpfCnpj><Cnpj>99999999000191</Cnpj></CpfCnpj><InscricaoMunicipal>1733160024</InscricaoMunicipal></Prestador></ConsultarNfseRpsEnvio>]]></ArquivoXML>
    </ConsultarNfseRps>
  </soap12:Body>
</soap12:Envelope>
```

## Retorno de ConsultaNfseRps

```xml
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <ConsultarNfseRpsResponse xmlns="http://nfse.goiania.go.gov.br/ws/">
            <ConsultarNfseRpsResult>&lt;ConsultarNfseRpsResposta xmlns="http://nfse.goiania.go.gov.br/xsd/nfse_gyn_v02.xsd"&gt;&lt;CompNfse&gt;&lt;Nfse&gt;&lt;InfNfse&gt;&lt;Numero&gt;370&lt;/Numero&gt;&lt;CodigoVerificacao&gt;MB94-C3ZA&lt;/CodigoVerificacao&gt;&lt;DataEmissao&gt;2011-08-30T00:00:00&lt;/DataEmissao&gt;&lt;OutrasInformacoes&gt;OUTRAS INFORMACOES SOBRE O SERVICO.&lt;/OutrasInformacoes&gt;&lt;ValoresNfse&gt;&lt;BaseCalculo&gt;0&lt;/BaseCalculo&gt;&lt;Aliquota&gt;5&lt;/Aliquota&gt;&lt;ValorIss&gt;0&lt;/ValorIss&gt;&lt;/ValoresNfse&gt;&lt;DeclaracaoPrestacaoServico&gt;&lt;IdentificacaoRps&gt;&lt;Numero&gt;14&lt;/Numero&gt;&lt;Serie&gt;UNICA&lt;/Serie&gt;&lt;Tipo&gt;1&lt;/Tipo&gt;&lt;/IdentificacaoRps&gt;&lt;DataEmissaoRps&gt;2011-08-30&lt;/DataEmissaoRps&gt;&lt;Competencia&gt;2011-08-30T00:00:00&lt;/Competencia&gt;&lt;Servico&gt;&lt;Valores&gt;&lt;ValorServicos&gt;1000.00&lt;/ValorServicos&gt;&lt;ValorDeducoes&gt;1000&lt;/ValorDeducoes&gt;&lt;ValorPis&gt;0.00&lt;/ValorPis&gt;&lt;ValorCofins&gt;0.00&lt;/ValorCofins&gt;&lt;ValorInss&gt;0.00&lt;/ValorInss&gt;&lt;ValorIr&gt;0.00&lt;/ValorIr&gt;&lt;ValorCsll&gt;0.00&lt;/ValorCsll&gt;&lt;ValorIss&gt;0&lt;/ValorIss&gt;&lt;Aliquota&gt;5&lt;/Aliquota&gt;&lt;DescontoIncondicionado&gt;0.00&lt;/DescontoIncondicionado&gt;&lt;/Valores&gt;&lt;IssRetido&gt;2&lt;/IssRetido&gt;&lt;CodigoTributacaoMunicipio&gt;791120000&lt;/CodigoTributacaoMunicipio&gt;&lt;Discriminacao&gt;TESTE DE GERACAO OK.\s\nEM PRODUCAO, SUA NOTA SERIA GERADA SEM CRITICAS.\s\nOS DADOS DESSA NOTA SAO FICTICIOS.&lt;/Discriminacao&gt;&lt;CodigoMunicipio&gt;0025300&lt;/CodigoMunicipio&gt;&lt;ExigibilidadeISS&gt;1&lt;/ExigibilidadeISS&gt;&lt;MunicipioIncidencia&gt;0025300&lt;/MunicipioIncidencia&gt;&lt;/Servico&gt;&lt;Prestador&gt;&lt;IdentificacaoPrestador&gt;&lt;CpfCnpj&gt;&lt;Cnpj&gt;02843557000110&lt;/Cnpj&gt;&lt;/CpfCnpj&gt;&lt;InscricaoMunicipal&gt;1300687&lt;/InscricaoMunicipal&gt;&lt;/IdentificacaoPrestador&gt;&lt;/Prestador&gt;&lt;Tomador&gt;&lt;IdentificacaoTomador&gt;&lt;CpfCnpj&gt;&lt;Cpf&gt;88888888888&lt;/Cpf&gt;&lt;/CpfCnpj&gt;&lt;/IdentificacaoTomador&gt;&lt;RazaoSocial&gt;JOSE DA SILVA TOMADOR DO SERVICO&lt;/RazaoSocial&gt;&lt;Endereco&gt;&lt;Endereco&gt;RUA DAS AMENDOEIRAS&lt;/Endereco&gt;&lt;Numero&gt;30&lt;/Numero&gt;&lt;Complemento&gt;LOTE 4&lt;/Complemento&gt;&lt;Bairro&gt;CENTRO&lt;/Bairro&gt;&lt;CodigoMunicipio&gt;0025300&lt;/CodigoMunicipio&gt;&lt;Uf&gt;GO&lt;/Uf&gt;&lt;Cep&gt;74823350&lt;/Cep&gt;&lt;/Endereco&gt;&lt;/Tomador&gt;&lt;OptanteSimplesNacional&gt;2&lt;/OptanteSimplesNacional&gt;&lt;/DeclaracaoPrestacaoServico&gt;&lt;/InfNfse&gt;&lt;versao&gt;2.0&lt;/versao&gt;&lt;/Nfse&gt;&lt;/CompNfse&gt;&lt;ListaMensagemRetorno&gt;&lt;MensagemRetorno&gt;&lt;Codigo&gt;L000&lt;/Codigo&gt;&lt;Mensagem&gt;NORMAL&lt;/Mensagem&gt;&lt;/MensagemRetorno&gt;&lt;/ListaMensagemRetorno&gt;&lt;/ConsultarNfseRpsResposta&gt;</ConsultarNfseRpsResult>
        </ConsultarNfseRpsResponse>
    </soap:Body>
</soap:Envelope>
```




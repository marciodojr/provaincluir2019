# Incluir Tecnologia - Prova de Desenvolvedor - 2019

Esta prova tem como objetivo verificar se o candidato possui as seguintes competências:

1. Entendimento básico de git/github.
2. Entendimento básico de configuração de um ambiente de desenvolvimento Web no Linux ou sistema equivalente.
3. Entendimento básico de PHP, orientação a objetos e padrões de estilo de código.
4. Capacidade de realizar pequenas modificações em aplicações existentes.

O candidato deverá executar as atividades definidas na seção **6. Atividade avaliativa**. As seções 1. a 5. descrevem instruções de instalação, uso e dicas sobre o projeto.

---

## 1. Configuração mínima para executar o projeto

- git
- Docker e Docker Compose
- Bom editor de código (é sugerido o **VSCode** com a extenção **PHP Intelephense**)
- **curl** e **jq** para realização das requisições http.

---

## 2. Instalação

### Docker

-   Docker (CE): https://docs.docker.com/install/linux/docker-ce/ubuntu/
-   Docker Compose: https://docs.docker.com/compose/install/
-   Etapas de pós-instalação: https://docs.docker.com/install/linux/linux-postinstall/

Importante: Para ver como este projeto utiliza o docker, abra o arquivo __docker-compose.yml__ no diretório raíz.

### curl e jq

- No linux digite o seguinte comando no terminal: `sudo apt install curl jq -y`

Importante: Você pode utilizar qualquer cliente http ao invés do curl. Ex: Postman, Chrome, Firefox, ...

---

## 3. Inicialização

### Docker

Na raíz do projeto, digite o comando abaixo (a aplicação ficará disponível enquanto esse comando estiver rodando):

```sh
docker-compose up
```

Você deverá ver uma série de informações referentes a inicialização dos *containers* da aplicação.

Em uma nova aba de terminal, digite o comando abaixo:

```sh
docker exec -it incluir2019-php bash
```

Com esse comando você terá acesso ao **Container do PHP** que roda a aplicação.

### Instalação de dependências

Para instalar todas as dependências de PHP do projeto, o seguinte comando deve ser executado dentro do **Container do PHP**:

```sh
composer install
```

### Acessando o banco de Dados

O banco de dados pode ser acessado via **Container do Mysql**. Digite o comando abaixo em uma nova aba do terminal.

```sh
docker exec -it incluir2019-sql bash
mysql -u provaincluir2019 -p provaincluir2019
# password: provaincluir2019
show tables;
```

### Criando tabelas do Banco de Dados

Dentro do **Container do PHP**, rode o comando abaixo:

```
vendor/bin/doctrine-migrations migrations:migrate
```

---

## 4. Sobre o Projeto:


### Realizando consultas


1. Consultar municípios

```sh
curl -X GET http://localhost:8888/municipio | jq
```

Resultado:

```json
{
  "code": 200,
  "message": "ok",
  "data": [
    {
      "id": 29,
      "codigo_ibge": "3132404",
      "nome_cidade": "Itajubá"
    },
    {
      "id": 30,
      "codigo_ibge": "3152501",
      "nome_cidade": "Pouso Alegre"
    }
  ]
}
```

1. Consultar bolsa família de um município (Itajubá = 3132404) em um intervalo no intervalo de datas [06/04/2016, 01/08/2016]

```sh
curl -X GET http://localhost:8888/municipio/3132404/bolsa-familia?data_inicial=06/04/2016&data_final=01/08/2016 | jq
```

Resultado:

```json
{
  "code": 200,
  "message": "ok",
  "data": [
    {
      "id": 29,
      "municipio": "Itajubá",
      "data_referencia": "01/05/2016",
      "valor_total": "R$ 459.034,00",
      "quantidade_beneficiados": 2679
    },
    {
      "id": 30,
      "municipio": "Itajubá",
      "data_referencia": "01/06/2016",
      "valor_total": "R$ 458.259,00",
      "quantidade_beneficiados": 2662
    },
    {
      "id": 31,
      "municipio": "Itajubá",
      "data_referencia": "01/07/2016",
      "valor_total": "R$ 549.784,00",
      "quantidade_beneficiados": 2851
    },
    {
      "id": 32,
      "municipio": "Itajubá",
      "data_referencia": "01/08/2016",
      "valor_total": "R$ 549.145,00",
      "quantidade_beneficiados": 2828
    }
  ]
}
```


### Doctrine ORM

O banco de dados do projeto é manipulado pelo Doctrine ORM. As entidades do banco de dados se encontram no diretório src/Entities.

Documentação do Doctrine ORM: <https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-objects.html#working-with-objects>

### Execução de testes

Os testes desse projeto são construídos a partir do framework de teste para PHP chamado [PhpUnit](https://phpunit.readthedocs.io/pt_BR/latest/).

Os comandos seguintes devem ser executados dentro do container do PHP.

-   Para executar todos os testes:

```sh
vendor/bin/phpunit
```

-   Para executar todos os testes de uma classe específica:

```sh
vendor/bin/phpunit --filter BolsaFamiliaMunicipioTest
```

-   Para executar todos os testes de uma classe específica exibindo mais detalhes

```sh
vendor/bin/phpunit --filter BolsaFamiliaMunicipioTest --testdox
```

-   Para executar um teste específico

```sh
vendor/bin/phpunit --filter testBolsaFamiliaMunicipioSuccess --testdox
```

## 6. Atividade avaliativa

### Introdução

1. Consultar o site de dados do governo e baixar a [lista de códigos do SIAFI](http://dados.gov.br/dataset/lista-de-orgaos-do-siafi).
2. Encontrar o código do SIAFI referente as prefeituras de Itajubá e Pouso Alegre.
3. Acessar a documentação de [API do governo](http://www.transparencia.gov.br/swagger-ui.html#!/Licita231245es32do32Poder32Executivo32Federal/licitacoesUsingGET).
4. Inserir data inicial 01/01/2016, data final 31/12/2018, código do orgão de Itajubá e clicar em "Testar Agora!".
5. Você verá um *json* de resultado.

### Descrição da Prova

A prova consiste em consultar os dados do governo (via api), salvar no banco de dados e criar uma rota de consulta. Para isso você deverá:

1. Persistência:

   1. Criar uma entidade na pasta `src/Entities` (nome sugerido: `Licitacao`) com os atributos (id, municipio, codigoOrgao). O campo municipio deve ser uma associação do tipo ManyToOne com a entidade Municipio (exatamente como feito para a entidade BolsaFamilia).
   2. Modificar a entidade Municipio para que possua o mapeamento OneToMany (exatamente como feito para a entidade BolsaFamilia)
   3. Validar o mapeamento via comando `vendor/bin/doctrine orm:validate-schema` (dentro do **Container do PHP**)
   4. Gerar uma migração via comando `vendor/bin/doctrine-migrations migrations:diff` (dentro do **Container do PHP**)
   5. Aplicar a migração no banco de dados via commando `vendor/bin/doctrine-migrations migrations:migrate`.
   6. Verificar (acessando o banco de dados) se a tabela de licitações foi criada.

2. Download dos dados:

   1. Criar um método para consulta de licitações no arquivo `src/Services/Transparencia.php` (similar ao que foi feito para o bolsa família).
   2. Criar uma semente (ou *fixture*) que utiliza a classe `Transparencia` para consultar programaticamente a sistema do governo e salvar os dados no banco de dados (similar ao arquivo `src/DbFixtures/BolsaFamiliaLoader.php`). Utilize os códigos dos dois orgãos pesquisados e as datas 01/01/2016 e 31/12/2018.
   3. Rodar o comando `php config/data-fixtures.php` para salvar os dados no banco de dados.
   4. Verificar (acessando o banco de dados) se a tabela de licitações foi preenchida.

3. Serviços
    1. Dentro da Pasta Services/Db criar uma classe para consultas de licitações (similar ao feito para o BolsaFamilia).
    2. Dentro da pasta Actions criar uma pasta chamada Licitacao e dentro dela uma action com o nome Licitacao.

4. Action e Rota
   1. Criar uma rota que utiliza o serviço criado e retorna os resultados de licitações (simular ao feito na action `src/Actions/BolsaFamilia/BolsaFamiliaMes`).
   2. Registrar a rota no arquivo `config/routes.php` (Sugestão de rota `/municipio/{codigoIbge}/licitacoes`).

5. Utilizando a rota criada:
    1. utilize o curl para verificar se os dados estão sendo retornados pela API (similar ao descrito na **Seção 4**).

### Entrega

1. A data de entrega da prova é definida pelo candidato ao receber a prova. Não serão aceitas provas após o prazo.
2. A prova deve ser armazenada no github do candidato e ele deve enviar um link para acesso no email `suporte@incluirtecnologia.com.br` com o link de acesso.

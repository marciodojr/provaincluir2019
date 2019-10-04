# Incluir Tecnologia - Prova de Desenvolvedor - 2019

Este repositório faz o uso da API REST do Portal da Transparência do Governo Federal para fazer consultas de informações relacionadas ao Bolsa Família.

# Configuração mínima para executar o projeto

## Docker

O Docker é um sistema de virtualização que permite criar, testar e implementar aplicações em um ambiente isolado, chamado de container. Uma imagem de container do docker é um pacote de software leve, independente e executável que inclui somente os recursos necessários para executar um determinado serviço. Dessa forma, por meio do Docker, as incompatibilidades entre os sistemas disponíveis são reduzidas, pois todos os serviços utilizados por uma aplicação podem ser disponibilizados através de imagens de container do docker, sem a necessidade de fazer a instalação desses softwares de serviços diretamente nos sistemas.

Para verificar quais serviços este projeto utiliza por meio de imagens de containers do Docker, abra o arquivo __docker-compose.yml__ no diretório raíz do projeto.

Documentação do Docker: <https://docs.docker.com/get-started/>

## Instalar o Docker e o Docker Compose

-   Docker (CE): https://docs.docker.com/install/linux/docker-ce/ubuntu/
-   Docker Compose: https://docs.docker.com/compose/install/
-   Etapas de pós-instalação: https://docs.docker.com/install/linux/linux-postinstall/

## Execução

Comando para executar todos os containers de serviços contidos no arquivo __docker-compose.yml__:

```sh
docker-compose up
```

### Acessar containers

Para acessar o container do PHP:

```sh
docker exec -it incluir2019-php
```

Para instalar todas as dependências de PHP do projeto, o seguinte comando deve ser executado dentro do container do PHP:

```sh
composer install
```

Para acessar o container do MySQL:

```sh
docker exec -it incluir2019-sql
```

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

-   Para executar o teste de um método específico

```sh
vendor/bin/phpunit --filter testBolsaFamiliaMunicipioSuccess --testdox
```
# Bibliotecas utilizadas no projeto

## Slim 4

O Slim é um micro framework de PHP voltado para a construção de aplicações web e APIs, funcionando basicamente como um dispatcher que recebe uma requisição HTTP, faz a chamada de uma função específica e retorna uma resposta HTTP.

Documentação do Slim 4: <http://www.slimframework.com/docs/v4/>

## Doctrine ORM

O banco de dados do projeto é manipulado pelo Doctrine ORM. As entidades do banco de dados se encontram no diretório src/Entities.

Documentação do Doctrine ORM: <https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/working-with-objects.html#working-with-objects>

## PHP-DI

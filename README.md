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

## 4. Dicas:

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

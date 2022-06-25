# API FUTEBOL BRASILEIRO ⚽

Projeto que está sendo desenvolvida a fim de buscar conhecimento e disponibilizar uma ferramenta API para consulta da tabela e rodadas do Campeonato Brasileiro, Libertadores, Suldamericana e Copa do Brasil.

Nesse projeto está sendo utilizado o framework [Laravel 8](https://laravel.com/docs/8.x) com [PHP 8](https://www.php.net/releases/8.0).

## Instalação

```bash
# Após clonar o repositório, execute esta linha de comando abaixo
$ composer install

# Criar arquivo .env do projeto
$ cp .env.example .env

# Gerar chave do laravel
$ php artisan key:generate
```

## Configuração de conexão com banco de dados

Escolha o SGBD de sua preferência e configure as credenciais de acordo com as variáveis do arquivo .env 

```bash
# Conexão Banco de Dados
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## Realizar migração das tabelas no banco de dados

Após finalizar a configuração de conexão com banco de dados, realize a migração das tabelas.

```bash
$ php artisan migrate
```

## Alimentar as tabelas do banco de dados de acordo com as informações dos campeonatos atualmente

Agora vamos trazer as informações dos campeonatos para o nosso banco de dados.

```bash
# Atualiza a tabela do campeonato brasileiro em nossa base de dados.
$ php artisan atualiza:tabela-brasileirao

# Atualiza os jogos do campeonato brasileiro em nossa base de dados.
$ php artisan atualiza:jogos-brasileirao
```

Banco de dados atualizado com as informações das maiores competições que envolvem os times brasileiros, vamos consultar via requisição.

Caso esteja utilizando o sistema localmente, execute o comando abaixo.

```bash
$ php artisan serve
```

Considerando a URL padrão da API o valor de (http://127.0.0.1:8000/api/)

| Método | URL | Descrição |
| --- | --- | --- |
| GET | ```urlApi```/campeonato/brasileiro/tabela | Retorna a tabela do campeonato brasileiro. |
| GET | ```urlApi```/campeonato/brasileiro/tabela-por-rodada/{rodada}/{temporada} | Retorna a tabela do campeonato brasileiro por rodada e temporada. |
| GET | ```urlApi```/campeonato/brasileiro/jogos | Retorna os jogos do campeonato brasileiro da rodada atual. |
| GET | ```urlApi```/campeonato/brasileiro/jogos-por-rodada/{rodada}/{temporada} | Retorna os jogos do campeonato brasileiro por rodada e temporada. |
| GET | ```urlApi```/campeonato/brasileiro/jogos-por-time/{nomeTime} | Retorna os jogos do campeonato brasileiro por nome do time. |

#### Exemplo de objeto retornado na consulta da tabela do campeonato brasileiro.

```code
[
  {
    "id_time": 798,
    "posicao": 1,
    "icone_width": 19,
    "icone_height": 19,
    "icone_url": "https://p2.trrsf.com/image/fget/cf/51/51/s1.trrsf.com/musa/pro/5vcvvctt97r69pfi89v8th577m.png",
    "nome_time": "Corinthians",
    "pontos": 22,
    "jogos": 12,
    "vitorias": 6,
    "empates": 4,
    "derrotas": 2,
    "gols_pro": 16,
    "gols_contra": 10,
    "saldo_de_gols": 6,
    "aproveitamento": 61
  },
]
```

#### Exemplo de objeto retornado na consulta de um jogo do campeonato brasileiro.

```code
[
  {
    "rodada": 13,
    "times_partida": "Corinthians x Goiás",
    "data_do_jogo": "2022-06-19",
    "local_jogo": "Neo Química Arena",
    "time_casa": "Corinthians",
    "time_casa_logo_width": 24,
    "time_casa_logo_height": 24,
    "time_casa_logo_alt": "Corinthians",
    "time_casa_logo_url": "https://p2.trrsf.com/image/fget/cf/51/51/s1.trrsf.com/musa/pro/5vcvvctt97r69pfi89v8th577m.png",
    "time_casa_abreviacao": "COR",
    "time_casa_gols": 1,
    "time_visitante_gols": 0,
    "data_e_horario_do_jogo": "Dom 19/06 16h00",
    "referencia_do_jogo": "corinthians-x-goias/72501",
    "time_visitante": "Goiás",
    "time_visitante_logo_width": 24,
    "time_visitante_logo_height": 24,
    "time_visitante_logo_alt": "Goiás",
    "time_visitante_logo_url": "https://p2.trrsf.com/image/fget/cf/51/51/s1.trrsf.com/musa/pro/1l1fquu71jjbfck687qvikc3l.png",
    "time_visitante_abreviacao": "GOI"
  },
]
```

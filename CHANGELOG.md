# Changelog

Todas as mudanças notáveis ​​neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
e este projeto adere ao [Versão Semântica](https://semver.org/spec/v2.0.0.html).

## [0.2.0] - 2022-06-23

### Added

- Adicionado uma rota para consulta de jogos do campeonato brasleiro por rodada e por temporada.
- Adicionado uma classe para retornar os dados das rodadas do campeonato.
- Adicionado uma tabela no banco de dados para armazenar as informações dos jogos das rodadas.
- Adicionado um model, service, interface, repository referente a tabela criada.
- Adicionado um comando para realizar a raspagem de dados dos jogos das rodadas e salvar no banco de dados.

### Changed

- Alterado função de recuperar parte (frações) de um texto (string) localizado na classe UtilsAbstract, agora com a opção de retornar apenas um registro do array ou todos os registros.

### Removed

- Model de Usuário que não estava sendo utilizado

## [0.1.0] - 2022-06-20

### Added 

- Adicionado uma rota para consultar a tabela do campeonato brasileiro por rodada e por temporada.
- Adicionado um arquivo exception personalizado, que será utilizado apenas em validações.

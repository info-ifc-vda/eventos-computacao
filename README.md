# eventos-computacao
<!-- ALL-CONTRIBUTORS-BADGE:START - Do not remove or modify this section -->
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors-)
<!-- ALL-CONTRIBUTORS-BADGE:END -->

## Instalação

1. Crie uma cópia do arquivo `.env.example` e renomeie-a para `.env`
2. Crie uma cópia do arquivo `docker-compose.dev.yml.example` e renomeie-a para `docker-compose.yml`
3. Inicie os containeres do projeto com o seguinte comando
```bash
    docker compose up -d --build
```
4. Instale as dependências do backend com os seguintes comandos:
```bash
docker compose exec api composer install
docker compose exec api cp .env.example .env
docker compose exec api php artisan key:generate
docker compose exec api php artisan migrate --force
```

5. Adicione alguns registros de teste para facilitar o desenvolvimento:
```bash
docker compose exec api php artisan db:seed # Rode apenas uma vez ou o haverá registros duplicados no seu banco de dados
```
O comando acima cria 3 usuários no banco de dados: admin@gmail.com, event_creator@gmail.com e common_user@gmail.com, todos com a senha "Senha123$"


A aplicação estará disponível na rota http://eventos.fsw-ifc.brdrive.localhost/api/v1/events



OBS 1: Em desenvolvimento, não é possível utilizar o https, caso estiver sofrendo com erros de "Não foi possível conectar, confira a rota e remova a parte do https"

OBS 2: Para o pessoal que trabalha no front, o HMR (Hot Module Reload) não funciona no windows, então recomendamos fortemente a utilização do WSL ou um SO Linux nativo para trabalhar adequadamente.

## Documentação

Para gerar a documentação da API, rode o seguinte comando:
```bash
docker compose exec api php artisan generate:docs
```
É recomendado rodar o comando a cada pull, pois a documentação é gerada somente ao executar o comando.
A documentação estará disponível na rota http://eventos.fsw-ifc.brdrive.localhost/swagger
## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="https://videira.ifc.edu.br/"><img src="https://avatars.githubusercontent.com/u/108874123?v=4?s=100" width="100px;" alt="info-ifc-vda"/><br /><sub><b>info-ifc-vda</b></sub></a><br /><a href="https://github.com/info-ifc-vda/eventos-computacao/commits?author=info-ifc-vda" title="Code">💻</a></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td align="center" size="13px" colspan="7">
        <img src="https://raw.githubusercontent.com/all-contributors/all-contributors-cli/1b8533af435da9854653492b1327a23a4dbd0a10/assets/logo-small.svg">
          <a href="https://all-contributors.js.org/docs/en/bot/usage">Add your contributions</a>
        </img>
      </td>
    </tr>
  </tfoot>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!
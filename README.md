# eventos-computacao

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
docker compose exec api php artisan passport:keys
docker compose exec api php artisan passport:client --password -q
```

A aplicação estará disponível na rota http://http://eventos.fsw-ifc.brdrive.localhost



OBS 1: Em desenvolvimento, não é possível utilizar o https, caso estiver sofrendo com erros de "Não foi possível conectar, confira a rota e remova a parte do https"

OBS 2: Em produção, é necessário criar um registro em /etc/hosts que redirecione `auth.eventos` para `127.0.0.1` e no nginx é necessário adicionar uma captura para este server_name

## Documentação

Para gerar a documentação da API, rode o seguinte comando:
```bash
docker compose exec api php artisan generate:docs
```
É recomendado rodar o comando a cada pull, pois a documentação é gerada somente ao executar o comando.
A documentação estará disponível na rota http://eventos.fsw-ifc.brdrive.localhost/swagger
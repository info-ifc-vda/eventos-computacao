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
docker compose exec api php artisan migrate --force
```

A aplicação estará disponível na rota [http://http://eventos.fsw-ifc.brdrive.localhost/api/v1/events](http://eventos.fsw-ifc.brdrive.localhost/api/v1/events).
OBS: Em desenvolvimento, não é possível utilizar o https, caso estiver sofrendo com erros de "Não foi possível conectar, confira a rota e remova a parte do https"
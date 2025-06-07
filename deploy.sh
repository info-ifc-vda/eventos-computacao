#!/bin/bash

# Script de deploy para aplicação Laravel + Vue.js, executando tudo dentro de contêineres
# Uso: ./deploy.sh [--api [--build] | --front | --all]

# Definir cores para mensagens
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para exibir mensagens de erro e sair
error_exit() {
    echo -e "${RED}Erro: $1${NC}" >&2
    exit 1
}

# Função para exibir mensagens de informação
info() {
    echo -e "${YELLOW}$1${NC}"
}

# Função para exibir mensagens de sucesso
success() {
    echo -e "${GREEN}$1${NC}"
}

# Verificar se o Docker e o Docker Compose estão instalados
command -v docker >/dev/null 2>&1 || error_exit "Docker não está instalado"
command -v docker compose >/dev/null 2>&1 || error_exit "Docker Compose não está instalado"

# Definir variáveis
PROJECT_DIR="$(pwd)"
API_DIR="${PROJECT_DIR}/api"
WEB_DIR="${PROJECT_DIR}/web"
PUBLIC_DIR="${PROJECT_DIR}/web/public"
DOCKER_COMPOSE_FILE="${PROJECT_DIR}/docker-compose.yml"
DEPLOY_MODE="all"
BUILD_FLAG="no"

# Processar argumentos
while [ $# -gt 0 ]; do
    case "$1" in
        --api)
            DEPLOY_MODE="api"
            shift
            ;;
        --front)
            DEPLOY_MODE="front"
            shift
            ;;
        --all)
            DEPLOY_MODE="all"
            shift
            ;;
        --build)
            BUILD_FLAG="yes"
            shift
            ;;
        *)
            error_exit "Argumento inválido: $1. Use --api [--build], --front ou --all"
            ;;
    esac
done

# Verificar se os diretórios e arquivos necessários existem
[ -d "$API_DIR" ] || error_exit "Diretório api/ não encontrado"
[ -d "$WEB_DIR" ] || error_exit "Diretório web/ não encontrado"
[ -d "$PUBLIC_DIR" ] || error_exit "Diretório public/ não encontrado"
[ -f "$PUBLIC_DIR/50x.html" ] || error_exit "Arquivo public/50x.html não encontrado"
[ -f "$DOCKER_COMPOSE_FILE" ] || error_exit "Arquivo docker-compose.yml não encontrado"

# Passo 1: Atualizar o repositório (no host)
# info "Atualizando o repositório..."
# git pull origin main || error_exit "Falha ao atualizar o repositório"
# success "Repositório atualizado com sucesso"

# Passo 2: Construir arquivos estáticos do Vue.js (se --front ou --all)
if [ "$DEPLOY_MODE" = "front" ] || [ "$DEPLOY_MODE" = "all" ]; then
    info "Construindo frontend Vue.js em um contêiner temporário..."
    docker run --rm -v "${WEB_DIR}:/var/www/web" -w /var/www/web node:20.15.0 sh -c "npm ci && npm run build:prod" || error_exit "Falha ao construir frontend Vue.js"
    success "Frontend construído com sucesso"
fi

# Passo 4: Executar migrations do Laravel (se --api ou --all)
if [ "$DEPLOY_MODE" = "api" ] || [ "$DEPLOY_MODE" = "all" ]; then
    info "Executando migrations do Laravel..."
    docker compose -f "$DOCKER_COMPOSE_FILE" exec -T api php artisan migrate --force || error_exit "Falha ao executar migrations"
    success "Migrations executadas com sucesso"
fi

# Passo 5: Gerar documentação da API (se --api ou --all)
if [ "$DEPLOY_MODE" = "api" ] || [ "$DEPLOY_MODE" = "all" ]; then
    info "Gerando documentação da API..."
    docker compose -f "$DOCKER_COMPOSE_FILE" exec -T api php artisan generate:docs || error_exit "Falha ao gerar documentação da API"
    success "Documentação da API gerada com sucesso"
fi

# Passo 6: Reiniciar contêineres
info "Reiniciando contêineres..."
cd "$PROJECT_DIR" || error_exit "Falha ao acessar diretório do projeto"
docker compose -f "$DOCKER_COMPOSE_FILE" down || error_exit "Falha ao parar contêineres"

if [ "$DEPLOY_MODE" = "api" ] && [ "$BUILD_FLAG" = "yes" ]; then
    info "Iniciando contêineres com --build..."
    docker compose -f "$DOCKER_COMPOSE_FILE" up -d --build || error_exit "Falha ao iniciar contêineres com build"
else
    info "Iniciando contêineres sem --build..."
    docker compose -f "$DOCKER_COMPOSE_FILE" up -d || error_exit "Falha ao iniciar contêineres"
fi

success "Contêineres reiniciados com sucesso"

# Passo 7: Verificar status dos contêineres
info "Verificando status dos contêineres..."
docker compose -f "$DOCKER_COMPOSE_FILE" ps || error_exit "Falha ao verificar status dos contêineres"

# Passo 8: Recarregar Nginx
info "Recarregando Nginx..."
docker compose -f "$DOCKER_COMPOSE_FILE" exec -T reverse-proxy nginx -s reload || error_exit "Falha ao recarregar Nginx"
success "Nginx recarregado com sucesso"

success "Deploy concluído com sucesso!"

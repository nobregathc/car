#!/bin/sh
set -e

# Se estiver configurado para migrar, executa as migracoes
if [ "$RUN_MIGRATIONS" != "false" ]; then
    echo "A verificar e executar migracoes da base de dados..."
    php artisan migrate --force || echo "Aviso: Nao foi possivel executar migracoes no arranque."
fi

# Otimizacoes para producao
if [ "$APP_ENV" = "production" ]; then
    echo "A aplicar cache de rotas e configuracoes..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Render fornece a variavel PORT (ex: 10000). Caso nao exista, usa 8000
PORT="${PORT:-8000}"
echo "A iniciar servidor na porta $PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"

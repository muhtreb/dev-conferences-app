#!/bin/bash

# Script de test pour l'image webserver

set -e

ACTION=${1:-start}
CONTAINER_NAME="webserver_test"
IMAGE_NAME="webserver:latest"
PORT="8080"

case "$ACTION" in
  build)
    echo "🔨 Construction de l'image webserver..."
    docker build -f docker/prod/webserver/Dockerfile -t "$IMAGE_NAME" .
    echo "✅ Image construite avec succès!"
    ;;

  start)
    echo "🚀 Démarrage du conteneur webserver..."
    docker run --rm -d -p "$PORT:8080" --name "$CONTAINER_NAME" "$IMAGE_NAME"
    sleep 2
    echo "✅ Conteneur démarré!"
    echo "📊 Status:"
    docker ps | grep "$CONTAINER_NAME" || echo "⚠️  Conteneur non trouvé"
    echo ""
    echo "🔍 Logs:"
    docker logs "$CONTAINER_NAME" 2>&1 | tail -10
    echo ""
    echo "🌐 Testez l'accès: http://localhost:$PORT"
    ;;

  stop)
    echo "🛑 Arrêt du conteneur webserver..."
    docker stop "$CONTAINER_NAME" 2>/dev/null || echo "⚠️  Conteneur déjà arrêté"
    echo "✅ Conteneur arrêté!"
    ;;

  logs)
    echo "📋 Logs du conteneur webserver:"
    docker logs -f "$CONTAINER_NAME"
    ;;

  shell)
    echo "🐚 Ouverture d'un shell dans le conteneur..."
    docker exec -it "$CONTAINER_NAME" sh
    ;;

  test)
    echo "🧪 Test de l'accès HTTP..."
    echo ""
    echo "Headers HTTP:"
    curl -I http://localhost:$PORT 2>&1 | head -15
    echo ""
    echo "Status des processus:"
    docker exec "$CONTAINER_NAME" ps aux | grep -E '(nginx|php-fpm)' | head -5
    ;;

  restart)
    echo "🔄 Redémarrage du conteneur..."
    $0 stop
    sleep 1
    $0 start
    ;;

  *)
    echo "Usage: $0 {build|start|stop|logs|shell|test|restart}"
    echo ""
    echo "Commandes disponibles:"
    echo "  build   - Construit l'image Docker"
    echo "  start   - Démarre le conteneur (défaut)"
    echo "  stop    - Arrête le conteneur"
    echo "  logs    - Affiche les logs en temps réel"
    echo "  shell   - Ouvre un shell dans le conteneur"
    echo "  test    - Teste l'accès HTTP et les processus"
    echo "  restart - Redémarre le conteneur"
    exit 1
    ;;
esac


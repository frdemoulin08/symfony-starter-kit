PURPLE='\033[0;35m'
NC='\033[0m' # No Color

APP_ENV=${APP_ENV:-dev}
if [ "$APP_ENV" != "dev" ]; then
  echo "${PURPLE}ABORT: APP_ENV=$APP_ENV (script réservé à dev)${NC}"
  exit 1
fi

echo "${PURPLE}#### DROP DATABASE SCHEMA ####${NC}"
php -d memory_limit=-1 bin/console doctrine:schema:drop --force --no-interaction
echo "${PURPLE}#### RESET MIGRATIONS ####${NC}"
php -d memory_limit=-1 bin/console doctrine:migrations:version --delete --all --no-interaction
echo "${PURPLE}#### EXECUTE MIGRATIONS ####${NC}"
php -d memory_limit=-1 bin/console doctrine:migrations:migrate --no-interaction
echo "${PURPLE}#### GENERATE FIXTURES ####${NC}"
php -d memory_limit=-1 bin/console --env=dev doctrine:fixtures:load --no-interaction

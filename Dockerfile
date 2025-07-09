FROM php:apache
COPY src/ /var/www/html/
RUN docker-php-ext-install mysqli

DB_CONTAINER_NAME=$(docker-compose ps -q db)
DB_NAME="mydb"
DB_USER="mario"
DB_PASSWORD="mario123"

docker exec -i "$DB_CONTAINER_NAME" mysql --default-character-set=utf8mb4 -u"$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" < "src/Vapor-Database-Implementation.sql"

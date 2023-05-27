## Start

### 1. Symfony CLI

```bash
composer install &&
yarn install && 
symfony server:serve -d
```

### 2. Docker compose

```bash
cd docker && docker-compose build && docker-compose up -d && 
docker exec php-fpm-sveak composer install &&
docker exec php-fpm-sveak bin/console doctrine:migrations:migrate

yarn install
```

## Fixtures

```bash
bin/console doctrine:fixtures:load
```

or in docker container

```bash
docker exec php-fpm-sveak doctrine:fixtures:load
```

### CONFIG

В конфиге .env.local необходимо заполнить ключи от сервиса DADATA \
Используется для определения мобильного оператора по номеру

### PATHS

```
GET /users/list - Список юзеров
GET /users/register - "Регистрация"
GET /users/profile/edit/{userId} - Редактор
GET /users/profile/{userId} - Просмотр
```

### CONSOLE

```
bin/console app:score [ID] - без ID выведет всех юзеров
```

### TESTS

```
make tests
```
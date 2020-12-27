```docker-compose up -d```
Заходим в php-fpm контейнер выполняем
```
composer install
bin/console doctrime:migrations:migrate

bin/phpunit

```

Затем выполняем запросы любым удобным способом
```
POST http://test.localhost/book/create
Content-Type: application/json

{
"name": "Моя книга"
}

###
POST http://test.localhost/book/create
Content-Type: application/json

{
"name": "Моя книга",
"authors": [3]
}

###

POST http://test.localhost/author/create
Content-Type: application/json

{
    "name": "Иван Иваныч"
}

###

GET http://test.localhost/book/search?name=quis
Content-Type: application/json

###

GET http://test.localhost/en/book/1
Content-Type: application/json

###
```
Без перевода хранимого в базе контента обойдемся - делать слишком много.

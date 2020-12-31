```docker-compose up -d```
Заходим в php-fpm контейнер (можно через  scripts/php-fpm.bat, можно как удобно) выполняем
```
composer install
vendor/bin/doctrine orm:schema-tool:update --force


```
Ручками заполняем базу

открываем ссылку http://test.localhost/tasks, смотрим выдачу 

Тестовое задание
================

Задача
------

>Необходимо создать микросервис GeoIP.
>https://docs.nexcess.net/article/what-is-geoip.html
>Микросервис должен принимать запрос на получение информации GET /ip2geo?ip=x.x.x.x и в ответ возвращать JSON с широтой, долготой и названиями страны и >города на английском языке.
>Если IP адрес не найден, то должен возвращаться пустой ответ с кодом 404.
>Для ускорения работы сервис должен кэшировать результаты запросов на 30 минут. >База данных адресов должна находиться внутри микросервиса.


Установка
---------

- git clone; cd <dir>
- composer install
- mkdir data;  wget http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.tar.gz; tar -zxf
- edit config/params.php if need
- add host to web server

```
# apache config example
<VirtualHost *:80>
    ServerName geoip.lo
    DocumentRoot /var/www/geoip/web
    <Directory /var/www/geoip/web>
	RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . index.php
    </Directory>
</VirtualHost>

```

Особенности
-----------

- кеш в redis
- отрицательные результаты не кешируем


Примеры
-------

- http://geoip.lo/ip2geo?ip=8.8.4.4
- http://geoip.lo/ip2geo?ip=10.1.1.1

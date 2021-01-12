# Swagger Cakephp
起動
```
$ docker-compose up -d
```
停止
```
$  docker stop $(docker ps -q) 
```
phpコンテナへの接続
```
$ docker-compose exec php bash
```
```
$ composer create-project --prefer-dist cakephp/app:^4.0 .
```
DBコンテナへの接続
```
$ docker-compose exec db bash
```
PHP Stanの実行
```
$ vendor/bin/phpstan analyse
```


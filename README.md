#### ---------- Развертывание приложения для локального тестирования --------------

docker-compose build
docker-compose up -d
docker exec -it php-test php artisan migrate
docker exec -it php-test php artisan db:seed

___________________________________________________________________________________

Для тестирования приложения используйте Postman либо другой REST Full API клиент

Файлы документации swager сохранены в 2х форматах [swager.json](src%2Fswager.json) и [swager.yaml](src%2Fswager.yaml)
#Запуск проекта
Поднимаем контейнеры:
```
make init
```
Создаём и накатываем миграции:
```
docker exec -it  php bin/console make:migration;
docker exec -it  php bin/console doctrine:migrations:migrate;
```
Загружаем тестовые данные из фикстур:
```
docker exec -it  php bin/console doctrine:fixtures:load
```
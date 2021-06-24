# Фронтэнд не добавил, а функционал проверял через запросы в POSTMAN.
База - mysql [phpmyadmin]

[GET] - localhost:8000/users - запрос для всех пользователей
[GET] - localhost:8000/users/{id} - запрос увидит тудулист для определенного пользователя
[POST] - localhost:8000/users/{id}/add - добавит таск в лист
[DELETE] - localhost:8000/users/{id}/{id}/delete - удалит данный таск
[PUT] - localhost:8000/users/{id}/{id}/update - изменит таск

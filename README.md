# User Registration API (Laravel + Redis)


## Архитектурный подход

Проект реализован с использованием **Pragmatic Domain-Oriented Clean Architecture**:

* предметные области изолированы
* бизнес-логика отделена от инфраструктуры
* Laravel используется строго как инфраструктурный и delivery-слой
* Redis используется как основное хранилище данных

Архитектура масштабируема, тестируема и не привязана к ORM.

### Общая схема слоёв

```
HTTP (Controller)
   ↓
Application (UseCases, DTO)
   ↓
Domain (Services, Value Objects)
   ↑
Infrastructure (Redis Repository, Jobs)
```

---

## Технологический стек

* PHP 8.4
* Laravel (latest)
* Redis 7
* Docker / Docker Compose
* PHPUnit
* Laravel Pint (code style)

---

## Запуск проекта

### Требования

* Docker
* Docker Compose

### Запуск

```bash
composer install 
./vendor/bin/sail up --build
./vendor/bin/sail bash

$ npm i 
$ npm run build
$ npm run dev
```

После запуска:

* API будет доступно по `http://localhost`
* Redis поднимается как отдельный сервис

---

## Хранение данных

Redis используется как **primary storage**, а не как кеш.

### Структура данных

* `user:{nickname}` — Hash с данными пользователя
* `users:index` — Set всех nickname

Пример:

```text
user:john => { nickname, avatar, created_at }
```

Такой подход позволяет:

* быстро проверять уникальность nickname
* эффективно получать список пользователей
* легко очищать устаревшие данные

---

## API

### Схема обработки регистрации

```
POST /api/register
   ↓
FormRequest (валидация, throttle)
   ↓
RegisterUserUseCase
   ↓
Domain Service (проверки, расчёты)
   ↓
RedisUserRepository
   ↓
Redis
```

---

## API

### Регистрация пользователя

**POST** `/api/register`

**Payload (multipart/form-data):**

```json
{
  "nickname": "john",
  "avatar": "file"
}
```

### Ограничения

* `nickname` — уникальный
* `avatar` — image (jpeg/png/webp)
* максимальный размер — 2MB
* RPS — N запросов в минуту (Laravel Throttle + Redis)

### Ответы

* `201 Created` — успешная регистрация
* `409 Conflict` — nickname уже существует
* `422 Unprocessable Entity` — ошибка валидации
* `429 Too Many Requests` — превышен лимит запросов

---

## Отображение пользователей

**GET** `/users`

Возвращает простой HTML со списком пользователей:

* nickname
* avatar

Без JavaScript, в соответствии с заданием.

---

## Очистка устаревших данных

Реализован Job для удаления пользователей, созданных более чем X минут назад.

### Схема очистки

```
Scheduler
   ↓
CleanupUsersJob
   ↓
RedisUserRepository
   ↓
Redis
```

* Job запускается по расписанию каждые N минут
* Очистка реализована на уровне Redis-данных

Альтернатива (не используется): Redis TTL

---

## Тестирование

Реализованы Feature-тесты для API:

* успешная регистрация
* проверка уникальности nickname
* валидация avatar
* throttle (RPS)

Запуск тестов:

```bash
php artisan test
```

---

## Code Quality

Используемые инструменты:

* Laravel Pint — code style
* PHPUnit — тестирование

Проект следует принципам:

* SRP
* Dependency Inversion
* явные зависимости

---

## Возможные улучшения

Данный проект является тестовым и может быть расширен следующими улучшениями:

* использование Redis TTL вместо job для автоочистки данных
* пагинация списка пользователей
* вынос хранения файлов в S3-совместимое хранилище
* добавление метрик и rate-limit по IP / nickname
* разделение read/write хранилищ при росте нагрузки
* добавление OpenAPI/Swagger спецификации

---

## Примечания

Проект намеренно не использует Eloquent и реляционную БД, чтобы продемонстрировать:

* работу с Redis как основным хранилищем
* контроль над архитектурой
* чистое разделение ответственности

---

## Автор

Тестовое задание выполнено в демонстрационных целях.

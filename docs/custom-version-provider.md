# Свой провайдер версии

Инструкция для пакета **maksde/filament-versions**: как добавить карточку с произвольной версией или метаданными на дашборд (`VersionsWidget`) и/или на страницу «Версии».

## Когда нужен свой провайдер

- Версия нестандартного пакета или внутреннего сервиса.
- Версия из **другого** подключения БД или Redis (не дефолтного).
- Любой источник: HTTP, файл, env, Artisan-команда и т.д.

Встроенные провайдеры можно **не копировать**: достаточно нового класса и записи в конфиге или вызова `widgetProviders()` / `pageProviders()` у плагина.

## Минимальный класс

Наследуйте `AbstractVersionProvider` и реализуйте только подпись и значение:

```php
<?php

namespace App\Filament\Versions;

use Maksde\FilamentVersions\Providers\AbstractVersionProvider;

class MyApiVersionProvider extends AbstractVersionProvider
{
    public function getLabel(): string
    {
        return __('my-app.filament.versions.my_api');
    }

    public function getVersion(): string
    {
        return config('services.my_api.version', 'n/a');
    }
}
```

`AbstractVersionProvider` уже отдаёт:

- `getIcon()` → `null`
- `getColumnSpan()` → `1`
- `getDescription()` → `null`

### Реализация интерфейса без базового класса

Если нужен только `VersionProvider`, реализуйте **все** методы интерфейса (`getLabel`, `getVersion`, `getIcon`, `getColumnSpan`, `getDescription`). Проще расширять `AbstractVersionProvider` и переопределять нужное.

## Зависимости из контейнера

Laravel создаёт провайдеры через контейнер. Пример с внедрением сервиса:

```php
<?php

namespace App\Filament\Versions;

use App\Services\ReleaseInfo;
use Maksde\FilamentVersions\Providers\AbstractVersionProvider;

class ReleaseVersionProvider extends AbstractVersionProvider
{
    public function __construct(protected ReleaseInfo $release) {}

    public function getLabel(): string
    {
        return __('my-app.filament.versions.release');
    }

    public function getVersion(): string
    {
        return $this->release->tag() ?? 'n/a';
    }
}
```

Аналогично у встроенного `LaravelVersionProvider` внедряется `Illuminate\Contracts\Foundation\Application`.

## Опциональные поля

### Описание под значением

Метод `getDescription(): ?string` попадает в `Stat::description()`. Для переводов используйте `__()` и ключи в `lang/` приложения или опубликованные файлы пакета.

### Иконка

Верните `Filament\Support\Icons\Heroicon::Outlined…` или другое значение, совместимое с Filament для `Stat::icon()`.

Не все иконки Heroicon хорошо читаются в компактной карточке; у встроенных провайдеров пакета в PHPDoc над `getIcon()` перечислены допустимые альтернативы.

### Ширина карточки

`getColumnSpan()` — то же, что `Stat::columnSpan()`: число, строка (`'full'`) или массив брейкпоинтов по документации Filament.

## Регистрация

### Через конфиг

В [`config/filament-versions.php`](../config/filament-versions.php) добавьте класс в массив **в нужном порядке**:

```php
'widget' => [
    'providers' => [
        // ...
        \App\Filament\Versions\MyApiVersionProvider::class,
    ],
],
```

Для страницы версий — то же в `page.providers`, если используете отдельную страницу.

### Через плагин (без правки config)

В `PanelProvider` классы **дополняют** списки из конфига:

```php
FilamentVersionsPlugin::make()
    ->widgetProviders([\App\Filament\Versions\MyApiVersionProvider::class])
    ->pageProviders([\App\Filament\Versions\MyApiVersionProvider::class]),
```

Проверьте, что для одной панели используется согласованная конфигурация плагина (один вызов `make()` с цепочкой или один стиль на проект).

## Переводы

1. **В приложении:** ключи в `lang/{locale}/my-app.php` (или отдельный файл) и `__('my-app.filament.versions.my_api')`.
2. **Переопределение пакета:** после `vendor:publish --tag=filament-versions-translations` правьте `lang/vendor/filament-versions/{locale}/filament-versions.php` по образцу ключей `defaults.*` и `page.*`.

Формат ключа пакета: `filament-versions::filament-versions.defaults.php` (группа `filament-versions`, файл `filament-versions.php`, ключ `defaults.php`).

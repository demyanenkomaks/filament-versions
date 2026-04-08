# Отображение версий в FilamentPhp.

[![Packagist Version](https://img.shields.io/packagist/v/maksde/filament-versions)](https://packagist.org/packages/maksde/filament-versions)
[![Packagist Downloads](https://img.shields.io/packagist/dt/maksde/filament-versions)](https://packagist.org/packages/maksde/filament-versions)
[![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/maksde/filament-versions/php)](https://packagist.org/packages/maksde/filament-versions)
[![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/maksde/filament-versions/filament%2Ffilament)](https://packagist.org/packages/maksde/filament-versions)
[![Packagist License](https://img.shields.io/packagist/l/maksde/filament-versions)](https://packagist.org/packages/maksde/filament-versions)

Пакет для [Filament](https://filamentphp.com/): карточки версий на базе `StatsOverviewWidget` / `Stat`. Поддерживаются встроенные источники (PHP, Laravel, Filament, окружение приложения, MySQL/MariaDB, PostgreSQL, Redis) и **любые свои** через контракт `VersionProvider`.

**Свой провайдер:** пошаговая инструкция — [docs/custom-version-provider.md](docs/custom-version-provider.md).

## Требования

- PHP `^8.2`
- Filament `^4.0 | ^5.0`

## Установка

```bash
composer require maksde/filament-versions
```

Опционально опубликовать конфиг и переводы:

```bash
php artisan vendor:publish --tag=filament-versions-config
php artisan vendor:publish --tag=filament-versions-translations
```

После изменения конфигурации в продакшене при необходимости выполните `php artisan config:clear`.

## Быстрый старт

1. Подключите плагин и виджет в провайдере панели (например в `PanelProvider`):

```php
use Filament\Panel;
use Maksde\FilamentVersions\FilamentVersionsPlugin;
use Maksde\FilamentVersions\Widgets\FilamentVersionsWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            FilamentVersionsPlugin::make(),
        ])
        ->widgets([
            FilamentVersionsWidget::class,
        ]);
}
```

Чтобы добавить классы провайдеров **без правки** `config`, используйте цепочку `FilamentVersionsPlugin::make()->widgetProviders([...])` и при необходимости `->pageProviders([...])` — подробнее в [docs/custom-version-provider.md](docs/custom-version-provider.md).

2. Настройте списки провайдеров в [`config/filament-versions.php`](config/filament-versions.php).

## Конфигурация

Файл задаёт **два независимых списка** провайдеров: для виджета на дашборде (`widget`) и для отдельной страницы (`page`). Они могут отличаться (например, на дашборде — только ядро стека, на странице — ещё и БД).

После `vendor:publish` правьте `config/filament-versions.php` в приложении; исходный эталон — в репозитории пакета.

| Ключ | Назначение |
|------|------------|
| `widget.providers` | Классы `VersionProvider` **в порядке карточек** для `FilamentVersionsWidget` |
| `widget.permission` | Имя права для показа виджета на дашборде (`$user->can()`, Shield; `null` — без проверки) |
| `widget.column_span` | Значение `columnSpan` виджета (`'full'`, число, массив брейкпоинтов — см. Filament) |
| `widget.sort` | Порядок виджета среди остальных (`null` — поведение Filament по умолчанию) |
| `page.permission` | Право на страницу версий: меню, URL и виджет в шапке страницы (`null` — без проверки) |
| `page.enabled` | Регистрировать ли страницу `VersionsPage` через плагин |
| `page.path` | Сегмент URL (slug) страницы версий |
| `page.providers` | Провайдеры **только** для страницы (виджет в шапке страницы); список не обязан совпадать с `widget.providers` |
| `page.should_register_navigation` | Показывать пункт в боковом / верхнем меню панели |
| `page.navigation_sort` | Сортировка пункта меню (`null` — без явного порядка) |
| `page.navigation_icon` | Иконка пункта меню: `Heroicon`, строка алиаса Filament или `null` |

**Дополнительные провайдеры из кода:** у `FilamentVersionsPlugin::make()` можно вызвать `widgetProviders([...])` и/или `pageProviders([...])` — переданные классы **дописываются в конец** соответствующего списка после массива из конфига.

**Кэш конфига:** после правок на проде выполните `php artisan config:clear` или пересоберите `config:cache`.

### Доступ и Filament Shield

Проверки идут через пользователя панели `Filament::auth()->user()` и метод `can()` (модели с **Laravel `Authorizable`**, в т.ч. роли/права Spatie и **Filament Shield**).

- **`widget.permission`** — если задано, `FilamentVersionsWidget::canView()` вызывает `FilamentVersionsAccess::canViewDashboardWidget()`.
- **`page.permission`** — если задано, `VersionsPage::canAccess()` и `VersionsPageWidget::canView()` используют `FilamentVersionsAccess::canViewVersionsPage()` / `canViewVersionsPageWidget()`.

Можно указать **массив** строк: пользователю достаточно иметь **любое** из прав (`canAny`).

Для произвольной логики можно вызвать в своём коде `Maksde\FilamentVersions\Support\FilamentVersionsAccess::check(...)` или переопределить `canView()` / `canAccess()` в **своих** подклассах виджета/страницы.

## Встроенные провайдеры

| Класс | Что показывает |
|-------|----------------|
| `PhpVersionProvider` | Версия PHP |
| `LaravelVersionProvider` | Версия приложения Laravel (`$app->version()`) |
| `FilamentVersionProvider` | Версия пакета `filament/filament` (Composer) |
| `AppEnvVersionProvider` | `config('app.env')` |
| `MysqlVersionProvider` | `VERSION()` через **дефолтное** подключение БД |
| `PostgresqlVersionProvider` | `version()` через **дефолтное** подключение БД |
| `RedisVersionProvider` | `redis_version` из **дефолтного** Redis-подключения |

MySQL, PostgreSQL и Redis зависят от `config/database.php`. При неверном драйвере, недоступном сервере или ошибке запроса в карточке обычно отображается текст ошибки или `n/a` — как реализовано в конкретном провайдере.

## Контракт провайдера (кратко)

Интерфейс: `Maksde\FilamentVersions\Contracts\VersionProvider`.

- Обязательно: `getLabel(): string`, `getVersion(): string`
- Также по контракту: `getIcon(): string|\BackedEnum|null`, `getColumnSpan(): array|int|string|null`, `getDescription(): ?string`

Удобная база: `Maksde\FilamentVersions\Providers\AbstractVersionProvider` — по умолчанию без иконки, `columnSpan = 1`, без описания.

Подробнее о своём классе, регистрации и переводах: [docs/custom-version-provider.md](docs/custom-version-provider.md).

## Локализация

Переводы группы `filament-versions` подгружаются из пакета. После публикации правьте файлы в `lang/vendor/filament-versions/{locale}/filament-versions.php`.

Примеры ключей:

- подписи карточек: `filament-versions::filament-versions.defaults.php` и др.
- страница: `filament-versions::filament-versions.page.title`, `…navigation_label`, `…navigation_group`

## Лицензия

Этот пакет является открытым программным обеспечением, лицензированным по [лицензии MIT](LICENSE.md).

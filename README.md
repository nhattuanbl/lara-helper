

## Installation
```
composer require nhattuanbl/larahelper
```
```
'providers' => [
    Nhattuanbl\LaraHelper\LaraHelperProvider::class,
],
```

## Usage
#### Test connection
```php artisan elastic:ping```

```php artisan mongo:ping {connection=mongodb} {--T|timeout=2}```

```php artisan mysql:ping {connection=mysql} {--T|timeout=2}```

```php artisan redis:ping {connection=mysql} {--T|timeout=2}```

#### Sql helpers
```SqlHelper::debug(QueryBuilder $builder): string```

#### File helpers
```FileHelper::byte2Readable(int|float $size): string```

#### IP helpers
```IpHelper::getUserIP(?Request $request = null): ?string```

#### String helpers
```StringHelper::isJson(string $string): bool```

```StringHelper::getValidEmail(?string $email): ?string```

```StringHelper::isDate($date): bool```

```StringHelper::vi2Ascii(?string $str): string```

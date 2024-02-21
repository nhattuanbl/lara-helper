

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

```php artisan redis:ping {connection=default} {--T|timeout=2}```

```php artisan postgres:ping {connection=pgsql} {--T|timeout=2}```

#### Command helpers
```php artisan db:create {name?} {connection=mysql}```

```php artisan db:copy {table_name} {--S|src_connection_name=babo_reader} {--D|dest_connection_name=mysql}```

#### Sql helpers
```SqlHelper::debug(QueryBuilder $builder): string```

#### File helpers
```FileHelper::byte2Readable(int|float $size): string```

```FileHelper::chmod_r(base_path('storage'), 0775)```

```FileHelper::chown_r(base_path('storage'), 'www-data')```

```FileHelper::chgrp_r(base_path('storage'), 'www-data')```

#### IP helpers
```IpHelper::getUserIP(?Request $request = null): ?string```

#### String helpers
```StringHelper::isJson(string $string): bool```

```StringHelper::getValidEmail(?string $email): ?string```

```StringHelper::isDate($date): bool```

```StringHelper::vi2Ascii(?string $str): string```

```StringHelper::seconds2ReadableTime(int $seconds): string```

```StringHelper::getDomain(string $url, bool $subdomain = true): ?string```

# php-array-helper

A tiny set of pure-PHP array helpers, autoloaded as global functions.

[![Packagist](https://img.shields.io/packagist/v/dskripchenko/php-array-helper)](https://packagist.org/packages/dskripchenko/php-array-helper)
[![Tests](https://github.com/dskripchenko/php-array-helper/actions/workflows/ci.yml/badge.svg)](https://github.com/dskripchenko/php-array-helper/actions/workflows/ci.yml)
[![License](https://img.shields.io/packagist/l/dskripchenko/php-array-helper)](LICENSE)

## Requirements

PHP 8.2 – 8.5.

## Install

```bash
composer require dskripchenko/php-array-helper
```

The functions are registered via Composer's `files` autoloading — no setup needed.

## Functions

### `array_merge_deep(array ...$arrays): array`

Recursively merges arrays. **String keys** are merged deeply (nested arrays are
combined); **integer keys** are appended rather than overwritten. Variadic.

```php
array_merge_deep(
    ['x' => ['a' => 1, 'b' => 2], 'y' => 1],
    ['x' => ['b' => 3, 'c' => 4], 'z' => 2],
);
// ['x' => ['a' => 1, 'b' => 3, 'c' => 4], 'y' => 1, 'z' => 2]

array_merge_deep([1, 2], [3, 4]); // [1, 2, 3, 4]
```

### `array_sort_deep(array $array, int $flags = SORT_REGULAR): array`

Recursively `ksort()`s the array and every nested array.

```php
array_sort_deep(['b' => 2, 'a' => ['y' => 1, 'x' => 2]]);
// ['a' => ['x' => 2, 'y' => 1], 'b' => 2]
```

### `array_is_associative(array $array): bool`

True when the array has any non-sequential (string / gapped) keys.

```php
array_is_associative(['x' => 1]); // true
array_is_associative([1, 2, 3]);  // false
```

### `array_get_signature(array $array, ?string $secret = null, ?string $salt = null, ?callable $hashing = null, int $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK): string`

A stable, **order-independent** signature of an array: it deep-sorts the array,
JSON-encodes it, wraps it in `secret + payload + salt` and hashes the result
(`md5` by default, or your own `$hashing` callable).

```php
array_get_signature(['a' => 1, 'b' => 2]) === array_get_signature(['b' => 2, 'a' => 1]); // true
```

## License

[MIT](LICENSE) © Denis Skripchenko

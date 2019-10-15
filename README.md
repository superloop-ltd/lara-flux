# Lara-flux

A simple wrapper for [influxdb-php](https://github.com/influxdata/influxdb-php/) in Laravel.

### WARNING ###

This package is in alpha and should not be used in production.

## Installing

* Install by composer command:

```sh
composer require superloop-ltd/lara-flux
```

### This package use auto-discover, if using laravel <5.5 you must use below settings

* Add this lines to yours config/app.php

```php
'providers' => [
//  ...
    LaraFlux\ServiceProvider::class,
]
```

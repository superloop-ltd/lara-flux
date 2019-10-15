<?php

namespace LaraFlux;

use Exception;
use InfluxDB\Point;
use LaraFlux\Facades\LaraFlux;
use Illuminate\Database\Eloquent\Model as IlluminateModel;

class Model
{
    public $database;

    public $key;

    public $time;

    public $value;

    public static function create($key, $value, $time = null)
    {
        $instance = new static();
        $instance->value = $value;

        throw_unless(LaraFlux::selectDB($instance->database)->writePoints([
            new Point(
                $key instanceof IlluminateModel ? $key->getKey() : $key,
                $value,
                [],
                [],
                $time ?: null
            )
        ]), new Exception('Unable to write to InfluxDB'));

        return $instance;
    }

    public static function query($key)
    {
        return new QueryBuilder($key, new static);
    }
}

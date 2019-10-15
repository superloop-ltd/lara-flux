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
                $instance->key($key),
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
        return new QueryBuilder((new static())->key($key), new static);
    }

    protected function key($key)
    {
        return $key instanceof IlluminateModel ? get_class($key).$key->getKey() : $key;
    }
}

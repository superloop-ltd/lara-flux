<?php

namespace LaraFlux;

use Exception;
use InfluxDB\Point;
use LaraFlux\Facades\LaraFlux;
use Illuminate\Database\Eloquent\Model as IlluminateModel;

class Model
{
    protected $database;

    public $time;

    public $value;

    public static function create($key, $value, $time = null)
    {
        $instance = new static();
        $instance->value = $value;
        $instance->time = $time ?: $instance->buildTimestamp();

        throw_unless(LaraFlux::selectDB($instance->database)->writePoints([
            new Point(
                $key instanceof IlluminateModel ? $key->getKey() : $key,
                $value,
                [],
                [],
                $instance->time
            )
        ]), new Exception('Unable to write to InfluxDB'));

        return $instance;
    }

    public static function query($key)
    {
        $instance = new static();

        return LaraFlux::selectDB($instance->database)
            ->getQueryBuilder()
            ->from($key instanceof IlluminateModel ? $key->getKey() : $key);
    }

    protected function buildTimestamp()
    {
        [$usec, $sec] = explode(' ', microtime());
        return sprintf('%d%06d', $sec, $usec*1000000);
    }
}

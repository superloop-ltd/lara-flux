<?php

namespace LaraFlux;

use Exception;
use LaraFlux\Facades\LaraFlux;
use Illuminate\Database\Eloquent\Model as IlluminateModel;

class QueryBuilder
{
    protected $key;

    protected $instance;

    protected $query;

    public function __construct($key, $instance)
    {
        $this->key = $key;
        $this->instance = $instance;

        $this->query = LaraFlux::selectDB($this->instance->database)
            ->getQueryBuilder()
            ->from($key instanceof IlluminateModel ? $key->getKey() : $key);
    }

    public function get()
    {
        return $this->buildModels($this->query->getResultSet()->getSeries()[0]['values'] ?? []);
    }

    protected function buildModels($data)
    {
        return collect($data)->transform(function ($point) {
            $model = clone $this->instance;

            [$model->time, $model->value] = $point;
            $model->key = $this->key;

            return $model;
        });
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return $this->query->{$name}(...$arguments);
        }

        if (method_exists($this->query, $name)) {
            $this->query->{$name}(...$arguments);

            return $this;
        }

        throw new Exception('Method not found');
    }
}

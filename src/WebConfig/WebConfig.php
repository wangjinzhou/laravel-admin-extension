<?php

namespace Howous\WebConfig;


use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $connection = config('admin.database.connection') ?: config('database.default');

        $table = config('admin.extensions.web_config.table', 'web_configs');

        $this->setConnection($connection);
        $this->setTable($table);
    }

}

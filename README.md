# laravel-admin-extension
laravel-admin 自定义扩展


## Installation

```
$ composer require howous/laravel-admin-extension

$ php artisan migrate
```

Open `app/Providers/AppServiceProvider.php`, and call the `Config::load()` method within the `boot` method:

```php
<?php

namespace App\Providers;

use Howous\WebConfig\WebConfigExtension;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        WebConfigExtension::load();
    }
}
```

导入后台配置菜单与权限: 

```
$ php artisan admin:import web_config
```


# BASE REPO PROJECT
[Laravel Sagara - Framework](https://gitlab.com/sagara-xinix/framework/laravel-sagara)

## New project
```bash
$ git clone git@gitlab.com:sagara-xinix/framework/laravel-sagara.git
```

Starting project
```bash
$ composer install
$ composer require laravel/passport
$ php artisan passport:install --uuids
$ php artisan passport:client --personal
```

`.env configuration`
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:xMxGUm+W8F+5wk8MiExpcX/BYHyMes0cxOCpHVybxws=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=appsemiling@gmail.com
MAIL_PASSWORD=Y4L+[?>94:Wry:fa
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@sagara.id
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

NEXMO_KEY=
NEXMO_SECRET=

FCM_SERVER_KEY=

FILESYSTEM_DRIVER=gcs
GOOGLE_CLOUD_PROJECT_ID=
GOOGLE_CLOUD_STORAGE_BUCKET=
GOOGLE_CLOUD_ACCOUNT_TYPE=
GOOGLE_CLOUD_PRIVATE_KEY_ID=
GOOGLE_CLOUD_PRIVATE_KEY=
GOOGLE_CLOUD_CLIENT_EMAIL=
GOOGLE_CLOUD_CLIENT_ID=
GOOGLE_CLOUD_AUTH_URI=
GOOGLE_CLOUD_TOKEN_URI=
GOOGLE_CLOUD_AUTH_PROVIDER_CERT_URL=
GOOGLE_CLOUD_CLIENT_CERT_URL=

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=client-id-value
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=unhashed-client-secret-value
```

## CREATE MIGRATION/MODEL
```bash
$ php artisan make:migration create_[TABLE_NAME]_table
```

## MIGRATE
```bash
$ php artisan migrate
```
## MODEL STRUCTURE

Create new Model
```bash
$ php artisan make:model Models/ModelName
```

`Models\ModelName.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;
class ModelName extends Resources {

    protected $table = 'person';

    protected $rules = array();

    protected $structures = array(
        "id" => [
            'name' => 'id',
            'label' => 'ID',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => true,
            'type' => 'integer',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],

        "field_name" => [
            'name' => 'field_name',
            'label' => 'Field Name',
            'display' => false,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => null
        ],
        ...
        "created_at" => [
            'name' => 'created_at',
            'label' => 'Created At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "updated_at" => [
            'name' => 'updated_at',
            'label' => 'Updated At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ],
        "deleted_at" => [
            'name' => 'deleted_at',
            'label' => 'Deleted At',
            'display' => false,
            'validation' => [
                'create' => null,
                'update' => null,
                'delete' => null,
            ],
            'primary' => false,
            'type' => 'datetime',
            'validated' => false,
            'nullable' => false,
            'note' => null
        ]
    );

    protected $searchable = array('first_name', 'last_name', 'phone', 'gender');

}


```

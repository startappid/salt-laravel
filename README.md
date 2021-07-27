# BASE REPO PROJECT
[Salt Laravel](https://github.com/faridlab/salt-laravel)

## REQUIREMENT
* PHP >= 7.4
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension

## New project
```bash
$ git clone git@github.com:faridlab/salt-laravel.git
```
NOTE: Don't forget to remove git from root project
```bash
laravel-project
$ rm -rf .git
```

### Starting project
`DO COPY .env.example > .env`

```bash
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install --uuids
$ php artisan db:seed
$ php artisan storage:link
```

See `.env` file example below, copy than paste to your `.env` file on your project

`.env configuration`
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

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

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
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

## OBSERVER
run command
```bash
$ php artisan make:observer [ObserverName]Observer
```
## OBSERVER LIFECYCLE

* retrieved : after a record has been retrieved.
* creating : before a record has been created.
* created : after a record has been created.
* updating : before a record is updated.
* updated : after a record has been updated.
* saving : before a record is saved (either created or updated).
* saved : after a record has been saved (either created or updated).
* deleting : before a record is deleted or soft-deleted.
* deleted : after a record has been deleted or soft-deleted.
* restoring : before a soft-deleted record is going to be restored.
* restored : after a soft-deleted record has been restored.

*Built-in Observer*
* Observer (default)
* Actorable (Trait)

default observer example:
`app/Observers/Observer.php`
```php
<?php

namespace App\Observers;
use Illuminate\Support\Facades\Storage;
class Observer
{

    public function retrieved($model) {

    }

    public function creating($model) {

    }

    public function created($model) {

    }

    public function updating($model) {

    }

    public function updated($model) {

    }

    public function saving($model) {
      foreach ($model->getAttributes() as $key => $value) {
        // Check attributes if file type then stored to disk
        if(request()->hasFile($key)) {
          $file = request()->file($key);
          $filename = uniqid().'-'.time().'.'.$file->getClientOriginalExtension();
          if(env('FILESYSTEM_DRIVER', 'local') == 'gcs') {
            $disk = Storage::disk('gcs');
            $path = $disk->put($model->getTable().'/'.$key, $file);
            $imgurl = ['https://storage.googleapis.com', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path];
            $model->setAttribute($key, implode('/', $imgurl));
          } else { // local
            $path = $file->storeAs($model->getTable().'/'.$key, $filename);
            $model->setAttribute($key, url('storage/app/'.$path));
          }
        }
      }
    }

    public function saved($model) {

    }

    public function restoring($model) {

    }

    public function restored($model) {

    }

    public function deleting($model) {

    }

    public function deleted($model) {

    }

    public function forceDeleted($model) {

    }
}

```

Use all of the bootable traits on the model.
Example: Actorable

`Models\ModelName.php`

```php
<?php

namespace App\Models;

...
use App\Observers\Traits\Actorable;

class ModelName extends Resources {

    use Actorable;
    ...
}
```


## ROLE AND PERMISSIONS
[Spatie - Laravel Permission](https://github.com/spatie/laravel-permission)
Permissions Patterns
--- *.*.* ---
first * it means table or page name
second * it means event
last * optional as detail information

Example:
users.create.role:user
the permission pattern above, user only has permission on *users* table
on event *create* or *insert* new data, with detail type *role is user*


## QUERY STRING

## FORMS Component

## BUGS

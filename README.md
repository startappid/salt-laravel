# BASE REPO PROJECT
[Sagara Laravel - Framework](https://gitlab.com/sagara-xinix/framework/sagara-laravel)

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
$ git clone git@gitlab.com:sagara-xinix/framework/sagara-laravel.git
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


        "fullname" => [
            'name' => 'fullname',
            'default' => null,
            'label' => 'Your full name label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'text',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your full name',
        ],

        "number" => [
            'name' => 'number',
            'default' => null,
            'label' => 'Your number label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'number',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your number',
        ],

        "email" => [
            'name' => 'email',
            'default' => null,
            'label' => 'Your email label',
            'display' => true,
            'validation' => [
                'create' => 'required|email',
                'update' => 'required|email',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'email',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your email',
        ],

        "checkbox" => [
            'name' => 'checkbox',
            'default' => null,
            'label' => 'Your Checkbox label',
            'display' => true,
            'validation' => [
                'create' => 'required|array',
                'update' => 'required|array',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'checkbox',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => false,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "checkbox_inline" => [
            'name' => 'checkbox_inline',
            'default' => 1,
            'label' => 'Your Checkbox label',
            'display' => true,
            'validation' => [
                'create' => 'required|array',
                'update' => 'required|array',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'checkbox',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => true,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "radio" => [
            'name' => 'radio',
            'default' => null,
            'label' => 'Your radio label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => false,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "radio_inline" => [
            'name' => 'radio_inline',
            'default' => 1,
            'label' => 'Your radio label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'radio',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // Options checkbox
            'inline' => true,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "color" => [
            'name' => 'color',
            'default' => null,
            'label' => 'Your color label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'color',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "date" => [
            'name' => 'date',
            'default' => null,
            'label' => 'Your date label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'date',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "time" => [
            'name' => 'time',
            'default' => null,
            'label' => 'Your time label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'time',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "datetime" => [
            'name' => 'datetime',
            'default' => null,
            'label' => 'Your datetime label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'datetime',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Pick your color',
        ],

        "hidden" => [
            'name' => 'hidden',
            'default' => 1,
            'label' => 'Your hidden label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'hidden',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "password" => [
            'name' => 'password',
            'default' => null,
            'label' => 'Your password label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'password',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => null,
        ],

        "range" => [
            'name' => 'range',
            'default' => null,
            'label' => 'Your range label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'range',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => null,
            // RANGE OPTION
            'step' => 1,
            'min' => 0,
            'max' => 10
        ],

        "telephone" => [
            'name' => 'telephone',
            'default' => null,
            'label' => 'Your telephone label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'tel',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your telephone',
        ],

        "url" => [
            'name' => 'url',
            'default' => null,
            'label' => 'Your url label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'url',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'Insert your telephone',
        ],

        "select" => [
            'name' => 'select',
            'default' => null,
            'label' => 'Your select label',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => false,
            'type' => 'select',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => '-- Select --',
            // Options checkbox
            'inline' => false,
            'options' => [
                [
                    'value' => 1,
                    'label' => 'Option 1'
                ],
                [
                    'value' => 2,
                    'label' => 'Option 2'
                ],
                [
                    'value' => 3,
                    'label' => 'Option 3'
                ],
                [
                    'value' => 4,
                    'label' => 'Option 3'
                ],
            ],
            // Options disabled according to value
            'options_disabled' => [2]
        ],

        "file" => [
            'name' => 'file',
            'default' => null,
            'label' => 'Your file label',
            'display' => true,
            'validation' => [
                'create' => 'required|file',
                'update' => 'required|file',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'file',
            'validated' => true,
            'nullable' => false,
            'note' => 'Help text run here',
            'placeholder' => 'pick your file',
            'accept' => 'image/*,.pdf'
        ],

        // TYPE: Reference
        "country_id" => [
            'name' => 'country_id',
            'default' => null,
            'label' => 'Country',
            'display' => true,
            'validation' => [
                'create' => 'required|integer',
                'update' => 'required|integer',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'reference',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Country',
            // Options reference
            'reference' => "countries", // Select2 API endpoint => /api/v1/countries
            'relationship' => 'country', // relationship request datatable
            'option' => [
                'value' => 'id',
                'label' => 'name'
            ]
        ],

        "textarea" => [
            'name' => 'textarea',
            'default' => null,
            'label' => 'Textarea',
            'display' => true,
            'validation' => [
                'create' => 'required|string',
                'update' => 'required|string',
                'delete' => null,
            ],
            'primary' => false,
            'required' => true,
            'type' => 'textarea',
            'validated' => true,
            'nullable' => false,
            'note' => null,
            'placeholder' => 'Textarea',
            // Options textarea
            'option' => [
                'rows' => 3,
                // 'cols' => 2
            ]
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

# TODO:
* [X] Resources(List): List data with datatables
* [X] Resources(Create): Create new data
* [X] Resources(Read): View detail data
* [X] Resources(Update): Update detail data
* [X] Resources(Destroy): Destroy (softdelete)
* [X] Resources(Trash): Trash (list trashes)
* [X] Resources(Delete): Delete (Hard Delete)
* [X] Resources(Restore): Restore deleted data
* [X] Resources(Export): Export data from DB
* [X] Resources(Import): Import data to DB


## QUERY STRING

## FORMS Component
* [X] Text
* [X] Number
* [X] Email
* [X] Checkbox
* [X] Color
* [X] Date
* [X] Datetime
* [X] File
* [X] Hidden
* [X] Image
* [X] Password
* [X] Radio
* [X] Range
* [X] Tel
* [X] Time
* [X] Url
* [X] Select
* [X] Reference (Select2)
* [ ] Slider
* [X] Datepicker
* [X] Datetimepicker
* [X] Timepicker

## BUGS
* [X] Api request from datatable only show 25 data
* [X] Component type "select" not selected on default value
* [X] API Unauthorize response HTML login page


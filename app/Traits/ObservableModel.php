<?php
namespace App\Traits;
use Illuminate\Support\Str;
use App\Observers\Observer as Observer;

trait ObservableModel
{
    protected static function boot() {
        parent::boot();
        $class_name = class_basename(__CLASS__);
        if(file_exists(app_path('Observers/'.Str::studly($class_name)).'Observer.php')) {
            $observer = app("App\Observers\\".Str::studly($class_name).'Observer');
            static::observe($observer);
            return;
        }
        static::observe(Observer::class);
    }
}

<?php

namespace App\Observers\Traits;
use Illuminate\Support\Facades\Auth;
use App\Models\Addresses;

trait Addressable
{
    /**
     * protected $addressFields = ['address'];
     * protected $addressCascade = false;
     */
    public $addressEnabled = true;

    protected $addressData = [];

    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootAddressable()
    {
        static::creating(function($model) {
            $addressFields = isset($model->addressFields)? $model->addressFields: ['address'];
            foreach ($addressFields as $field) {
                if(!request()->has($field)) continue;
                $model->addressData[] = request()->get($field);
            }
        });

        static::created(function($model) {
            if(!count($model->addressData)) return;
            foreach ($model->addressData as $data) {
                $data['foreign_table'] = $model->getTable();
                $data['foreign_id'] = $model->id;
                $file = Addresses::create($data);
            }
        });

        static::updating(function($model) {
            $addressFields = isset($model->addressFields)? $model->addressFields: ['address'];
            foreach ($addressFields as $field) {
                if(!request()->has($field)) continue;
                $model->addressData[] = request()->get($field);
            }
        });

        static::updated(function($model) {
            if(!count($model->addressData)) return;
            $addressCascade = isset($model->addressCascade)?: false;
            foreach ($model->addressData as $data) {
                $data['foreign_table'] = $model->getTable();
                $data['foreign_id'] = $model->id;
                if($addressCascade) {
                    Addresses::updateOrCreate(
                        [
                            'foreign_table' => $data['foreign_table'],
                            'foreign_id' => $data['foreign_id']
                        ],
                        $data
                    );
                } else {
                    $file = Addresses::create($data);
                }
            }
        });

        static::restored(function($model) {
            $addressCascade = isset($model->addressCascade)?: false;
            if(!$addressCascade) return;
            Addresses::withTrashed()
                ->where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->restore();
        });

        static::deleted(function($model) {
            $addressCascade = isset($model->addressCascade)?: false;
            if(!$addressCascade) return;
            Addresses::where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->delete();
        });

        static::forceDeleted(function($model) {
            $addressCascade = isset($model->addressCascade)?: false;
            if(!$addressCascade) return;
            Addresses::withTrashed()
                ->where('foreign_table', $model->getTable())
                ->where('foreign_table', $model->id)
                ->forceDelete();
        });

    }
}

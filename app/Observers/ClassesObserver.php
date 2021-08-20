<?php

namespace App\Observers;
use App\Models\Levels;
use App\Models\Degrees;
use App\Models\Majors;

class ClassesObserver extends Observer
{

    public function creating($model) {

        if(empty($model->class) || is_null($model->class)) {
            $classFormatted = '';
            $level = Levels::find($model->level_id);
            if(!is_null($level)){
                $classFormatted .= $level->level;
            }

            $degree = Degrees::find($model->degree_id);
            if(!is_null($degree)){
                $classFormatted .= ' '. $degree->title;
            }

            $major = Majors::find($model->major_id);
            if(!is_null($major)){
                $classFormatted .= ' '. $major->title;
            }
            $model['class'] = $classFormatted;
        }
    }

    public function updating($model) {
        if(!$model->isDirty('class')) {
            $classFormatted = '';
            $level = Levels::find($model->level_id);
            if(!is_null($level)){
                $classFormatted .= $level->level;
            }

            $degree = Degrees::find($model->degree_id);
            if(!is_null($degree)){
                $classFormatted .= ' '. $degree->title;
            }

            $major = Majors::find($model->major_id);
            if(!is_null($major)){
                $classFormatted .= ' '. $major->title;
            }
            $model['class'] = $classFormatted;
        }
    }

}

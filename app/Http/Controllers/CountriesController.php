<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

// EXCEPTIONS
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernelException\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Validation\Rule;
use ReflectionException;
use Exception;
use NotFoundHttpException;
use InvalidArgumentException;

class CountriesController extends ResourcesController {

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(Request $request, Resources $model) {
        parent::__construct($request, $model);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $collection = null) {
        if(!$this->model) abort(404);

        try {
            $data = $this->model->with('files')->findOrFail($id);
            $this->setTitle(Str::title(Str::singular($this->table_name)));
            if(file_exists(resource_path('views/'.$this->table_name.'/show.blade.php'))) {
                $this->view = view($this->table_name.'.show');
            } else {
                $this->view = view('resources.show');
            }

            if(isset($data)) {
                foreach($this->structures as $key => $item) {
                    $this->structures[$key]['value'] = $data->{$item['name']};
                }
            }

            $forms = $this->model->getForms();
            return $this->view->with($this->respondWithData(array(
                'data' => $data,
                'forms' => $forms
            )));
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (Exception $e) {
            abort(501);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $collection = null) {
        if(!$this->model) abort(404);
        try {
            $data = $this->model->with('files')->findOrFail($id);
            $this->setTitle(Str::title(Str::singular($this->table_name)));

            if(file_exists(resource_path('views/'.$this->table_name.'/edit.blade.php'))) {
                $this->view = view($this->table_name.'.edit');
            } else {
                $this->view = view('resources.edit');
            }

            foreach($this->structures as $key => $item) {
                $this->structures[$key]['value'] = $data->{$item['name']};
            }
            $forms = $this->model->getForms();
            return $this->view->with($this->respondWithData(array(
                'data' => $data,
                'forms' => $forms
            )));

        } catch (Exception $e) {

        }
    }

}

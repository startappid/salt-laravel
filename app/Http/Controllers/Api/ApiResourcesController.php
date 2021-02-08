<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Resources;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Services\ResponseService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ApiResourcesController extends Controller
{
    protected $table_name = null;
    protected $model = null;
    protected $structures = array();
    protected $segments = [];
    protected $segment = null;
    protected $responder = null;

    public $response = array();

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(Request $request, Resources $model, ResponseService $responder) {

        try {
            $this->responder = $responder;
            $this->segment = $request->segment(3);
            if(file_exists(app_path('Models/'.Str::studly($this->segment)).'.php')) {
                $this->model = app("App\Models\\".Str::studly($this->segment));
            } else {
                if($model->checkTableExists($this->segment)) {
                    $this->model = $model;
                    $this->model->setTable($this->segment);
                }
            }
            if($this->model) {
                $this->structures = $this->model->getStructure();
                // SET default Authentication
                $this->middleware('auth:api', ['only' => $this->model->getAuthenticatedRoutes()]);
            }

            if(is_null($this->table_name)) $this->table_name = $this->segment;
            $this->segments = $request->segments();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    private function checkPermissions($authenticatedRoute, $authorize) {
        if(in_array($authenticatedRoute, $this->model->getAuthenticatedRoutes())) {
            $table = $this->model->getTable();
            $generatedPermissions = [$table.'.*.*', $table.'.'.$authorize.'.*'];
            $defaultPermissions = $this->model->getPermissions($authorize);
            $permissions = array_merge($generatedPermissions, $defaultPermissions);
            $user = Auth::user();
            if(!$user->hasAnyPermission($permissions)) {
                throw new \Exception('You do not have authorization.');
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {

        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('index', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $model = $this->model->newQuery();
            $format = $request->get('format', 'default');

            $limit = intval($request->get('limit', 25));
            if($limit > 100) {
                $limit = 100;
            }

            $p = intval($request->get('page', 1));
            $page = ($p > 0 ? $p - 1: $p);

            $search = null;
            if($format == 'datatable') {
                $limit = intval($request->get('length', $limit));
                $p = intval($request->get('start', 0)) / $limit;
                $page = $p;
                $search_params = $request->get('search');
                $search = $search_params['value'];
                $draw = $request['draw'];
                unset($request['search']);
                unset($request['draw']);
                unset($request['start']);
                unset($request['length']);
                unset($request['columns']);
                unset($request['format']);
                unset($request['_token']);
                unset($request['_']);
            }
            $search = $request->get('search', $search);

            // FIXME: this line below not running
            $fields = $request->except(['page', 'limit', 'with', 'search', 'withtrashed', 'orderBy']);
            if(count($fields)) {
                foreach ($fields as $field => $value) {
                    $model->where($field, $value);
                }
            }

            if($search) {
                $searchable = $this->model->getSearchable();
                $model->where(function($query) use ($searchable, $search) {
                    foreach ($searchable as $field) {
                        $query->orWhere($field, 'LIKE', '%' . trim($search) . '%');
                    }
                });
            }

            if($request->has('with') && $request->get('with')) {
                $relations = explode(',', $request->get('with'));
                // $model->with($relations);
                foreach ($relations as $relation) {
                    $model->with([$relation => function($query) use($request) {
                        if($request->has('withtrashed')) {
                            $query->withTrashed();
                        }
                    }]);
                }
            }

            if($request->has('withtrashed')) {
                $model->withTrashed();
            }

            if($request->has('orderBy')) {
                $order = $request->get('orderBy');
                foreach ($order as $key => $value) {
                    $model->orderBy($key, $value);
                }
            }

            $modelCount = clone $model;
            $count = $modelCount->count();
            $meta = array(
                'recordsTotal' => $this->model->count(),
                'recordsFiltered' => $count
            );

            $data = $model
                        ->offset($page * $limit)
                        ->limit($limit)
                        ->get();

            $this->responder->set('message', 'Data retrieved.');
            $this->responder->set('meta', $meta);
            $this->responder->set('data', $data);
            if($format == 'datatable') {
                $this->responder->set('draw', $draw);
                $this->responder->set('recordsFiltered', $meta['recordsFiltered']);
                $this->responder->set('recordsTotal', $meta['recordsTotal']);
            }
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('store', 'create');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $validator = $this->model->validator($request);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }
            foreach ($request->all() as $key => $value) {
                if(Str::startsWith($key, '_')) continue;
                $this->model->setAttribute($key, $value);
            }
            $this->model->save();
            $this->responder->set('message', Str::title(Str::singular($this->table_name)).' created!');
            $this->responder->set('data', $this->model);
            $this->responder->setStatus(201, 'Created.');
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('show', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            if($request->has('with') && $request->get('with')) {
                $relations = explode(',', $request->get('with'));
                if($request->has('withtrashed')) {
                    $data = $this->model->with($relations)->withTrashed()->find($id);
                } else {
                    $data = $this->model->with($relations)->find($id);
                }
            } else {
                if($request->has('withtrashed')) {
                    $data = $this->model->withTrashed()->find($id);
                } else {
                    $data = $this->model->find($id);
                }
            }
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('update', 'update');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $model = $this->model::find($id);
            if(is_null($model)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = $this->model->validator($request, 'update', $id);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            foreach ($request->all() as $key => $value) {
                if(Str::startsWith($key, '_')) continue;
                $model->setAttribute($key, $value);
            }

            $model->save();

            $this->responder->set('message', 'Data updated');
            $this->responder->set('data', $model);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('patch', 'update');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {

            $model = $this->model::find($id);
            if(is_null($model)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }

            $validator = $this->model->validator($request, 'patch', $id);
            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            foreach ($request->all() as $key => $value) {
                if(Str::startsWith($key, '_')) continue;
                $model->setAttribute($key, $value);
            }

            $model->save();

            $this->responder->set('message', 'Data patched');
            $this->responder->set('data', $model);
            return $this->responder->response();
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('destroy', 'destroy');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $id = intval($id) > 0 ? intval($id): $id;
            if(!is_int($id)) {
                if($id == "selected") { // Delete all selected IDs
                    if($request->has('selected')) {
                        $ids = $request->get('selected');
                        $model = $this->model->whereIn('id', $ids);
                        if($model->count() < 1) {
                            $this->responder->set('message', 'Selected IDs not found');
                            $this->responder->setStatus(404, 'Not Found');
                            return $this->responder->response();
                        }
                        $model->delete();
                        $this->responder->set('message', 'Selected IDs are deleted');
                        $this->responder->set('data', $model);
                        return $this->responder->response();
                    } else {
                        $this->responder->set('message', "Selected IDs is required");
                        $this->responder->setStatus(400, 'Bad Request.');
                        return $this->responder->response();
                    }
                } else if($id == "all") { // Delete all selected
                    $model = $this->model->whereNull('deleted_at');
                    if($model->count() < 1) {
                        $this->responder->set('message', 'There is not data found');
                        $this->responder->setStatus(404, 'Not Found');
                        return $this->responder->response();
                    }
                    $model->delete();
                    $this->responder->set('message', 'All data are deleted');
                    $this->responder->set('data', $model);
                    return $this->responder->response();
                } else {
                    $this->responder->set('message', "Request method not defined");
                    $this->responder->setStatus(400, 'Bad Request.');
                    return $this->responder->response();
                }

            } else { // Pointing to spesific data by ID
                $model = $this->model::find($id);
                if(is_null($model)) {
                    $this->responder->set('message', 'Data not found');
                    $this->responder->setStatus(404, 'Not Found');
                    return $this->responder->response();
                }
                $model->delete();
                $this->responder->set('message', 'Data deleted');
                $this->responder->set('data', $model);
                return $this->responder->response();
            }
        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('trash', 'trash');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $model = $this->model->onlyTrashed();
            $format = $request->get('format', 'default');

            $limit = intval($request->get('limit', 25));
            if($limit > 100) {
                $limit = 100;
            }

            $p = intval($request->get('page', 1));
            $page = ($p > 0 ? $p - 1: $p);

            $search = null;
            if($format == 'datatable') {
                $limit = intval($request->get('length', $limit));
                $p = intval($request->get('start', 0)) / $limit;
                $page = $p;
                $search_params = $request->get('search');
                $search = $search_params['value'];
                $draw = $request['draw'];
                unset($request['search']);
                unset($request['draw']);
                unset($request['start']);
                unset($request['length']);
                unset($request['columns']);
                unset($request['format']);
                unset($request['_token']);
                unset($request['_']);
            }
            $search = $request->get('search', $search);

            // FIXME: this line below not running
            $fields = $request->except(['page', 'limit', 'with', 'search', 'withtrashed', 'orderBy']);
            if(count($fields)) {
                foreach ($fields as $field => $value) {
                    $model->where($field, $value);
                }
            }

            if($search) {
                $searchable = $this->model->getSearchable();
                $model->where(function($query) use ($searchable, $search) {
                    foreach ($searchable as $field) {
                        $query->orWhere($field, 'LIKE', '%' . trim($search) . '%');
                    }
                });
            }

            if($request->has('with') && $request->get('with')) {
                $relations = explode(',', $request->get('with'));
                // $model->with($relations);
                foreach ($relations as $relation) {
                    $model->with([$relation => function($query) use($request) {
                        if($request->has('withtrashed')) {
                            $query->withTrashed();
                        }
                    }]);
                }
            }

            if($request->has('withtrashed')) {
                $model->withTrashed();
            }

            if($request->has('orderBy')) {
                $order = $request->get('orderBy');
                foreach ($order as $key => $value) {
                    $model->orderBy($key, $value);
                }
            }

            $modelCount = clone $model;
            $count = $modelCount->count();
            $meta = array(
                'recordsTotal' => $this->model->count(),
                'recordsFiltered' => $count
            );

            $data = $model
                        ->offset($page * $limit)
                        ->limit($limit)
                        ->get();

            $this->responder->set('message', 'Data retrieved.');
            $this->responder->set('meta', $meta);
            $this->responder->set('data', $data);
            if($format == 'datatable') {
                $this->responder->set('draw', $draw);
                $this->responder->set('recordsFiltered', $meta['recordsFiltered']);
                $this->responder->set('recordsTotal', $meta['recordsTotal']);
            }
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('trashed', 'read');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $data = $this->model->onlyTrashed()->find($id);
            if(is_null($data)) {
                $this->responder->set('message', 'Data not found');
                $this->responder->setStatus(404, 'Not Found');
                return $this->responder->response();
            }
            $this->responder->set('message', 'Data retrieved');
            $this->responder->set('data', $data);
            return $this->responder->response();
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('restore', 'restore');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $id = intval($id) > 0 ? intval($id): $id;
            if(!is_int($id)) {
                if($id == "selected") { // Delete all selected IDs
                    if($request->has('selected')) {
                        $ids = $request->get('selected');
                        $model = $this->model->onlyTrashed()->whereIn('id', $ids);
                        if($model->count() < 1) {
                            $this->responder->set('message', 'Selected IDs not found');
                            $this->responder->setStatus(404, 'Not Found');
                            return $this->responder->response();
                        }
                        $model->restore();
                        $this->responder->set('message', 'Selected IDs are restored');
                        $this->responder->set('data', $model);
                        return $this->responder->response();
                    } else {
                        $this->responder->set('message', "Selected IDs is required");
                        $this->responder->setStatus(400, 'Bad Request.');
                        return $this->responder->response();
                    }
                } else if($id == "all") { // Delete all selected
                    $model = $this->model->onlyTrashed();
                    if($model->count() < 1) {
                        $this->responder->set('message', 'There is not data found');
                        $this->responder->setStatus(404, 'Not Found');
                        return $this->responder->response();
                    }
                    $model->restore();
                    $this->responder->set('message', 'All data are restored');
                    $this->responder->set('data', $model);
                    return $this->responder->response();
                } else {
                    $this->responder->set('message', "Request method not defined");
                    $this->responder->setStatus(400, 'Bad Request.');
                    return $this->responder->response();
                }
            } else { // Pointing to spesific data by ID
                $data = $this->model->onlyTrashed()->find($id);
                if(is_null($data)) {
                    $this->responder->set('message', 'Data not found');
                    $this->responder->setStatus(404, 'Not Found');
                    return $this->responder->response();
                }
                $data->restore();
                $this->responder->set('message', 'Data restored');
                $this->responder->set('data', $data);
                return $this->responder->response();
            }
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Permanent delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $collection, $id = null)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->checkPermissions('delete', 'delete');
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $id = intval($id) > 0 ? intval($id): $id;
            if(!is_int($id)) {
                if($id == "selected") { // Delete all selected IDs
                    if($request->has('selected')) {
                        $ids = $request->get('selected');
                        $model = $this->model->onlyTrashed()->whereIn('id', $ids);
                        if($model->count() < 1) {
                            $this->responder->set('message', 'Selected IDs not found');
                            $this->responder->setStatus(404, 'Not Found');
                            return $this->responder->response();
                        }
                        $model->forceDelete();
                        $this->responder->set('message', 'Selected IDs are deleted');
                        $this->responder->set('data', $model);
                        return $this->responder->response();
                    } else {
                        $this->responder->set('message', "Selected IDs is required");
                        $this->responder->setStatus(400, 'Bad Request.');
                        return $this->responder->response();
                    }
                } else if($id == "all") { // Delete all selected
                    $model = $this->model->onlyTrashed();
                    if($model->count() < 1) {
                        $this->responder->set('message', 'There is not data found');
                        $this->responder->setStatus(404, 'Not Found');
                        return $this->responder->response();
                    }
                    $model->forceDelete();
                    $this->responder->set('message', 'All data are deleted');
                    $this->responder->set('data', $model);
                    return $this->responder->response();
                } else {
                    $this->responder->set('message', "Request method not defined");
                    $this->responder->setStatus(400, 'Bad Request.');
                    return $this->responder->response();
                }
            } else { // Pointing to spesific data by ID
                $data = $this->model->onlyTrashed()->find($id);
                if(is_null($data)) {
                    $this->responder->set('message', 'Data not found');
                    $this->responder->setStatus(404, 'Not Found');
                    return $this->responder->response();
                }
                $data->forceDelete();
                $this->responder->set('message', 'Data permanent deleted!');
                $this->responder->set('data', $data);
                return $this->responder->response();
            }
        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import($id)
    {
        //
    }

    /**
     * Export data to CSV, EXCEL, etc (TBD)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $collection)
    {
        if(is_null($this->model)) {
            $this->responder->set('message', "Model not found!");
            $this->responder->setStatus(404, 'Not found.');
            return $this->responder->response();
        }

        try {
            $this->authorize('export', $this->model);
        } catch (\Exception $e) {
            $this->responder->set('message', 'You do not have authorization.');
            $this->responder->setStatus(401, 'Unauthorized');
            return $this->responder->response();
        }

        try {
            $validator = Validator::make($request->all(), [
                'type' => 'nullable|string|in:csv,xlsx,sql',
                'columns' => 'nullable|array',
            ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $this->responder->set('message', 'Data exported.');
            $this->responder->set('data', []);
            return $this->responder->response();

        } catch(\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report($id)
    {
        //
    }

}

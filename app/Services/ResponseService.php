<?php
namespace App\Services;

use Illuminate\Http\Request;

class ResponseService {

    protected $data = array();
    protected $headers = array();
    protected $status = 200;

    /**
     * Create a new ResponseService instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this->data = array(
            'app' => config('app.name'),
            'version' => env('APP_VERSION', 'v1'),
            'api_version' => env('API_VERSION', 'v1'),
            'status' => 'OK',
            'collection' => null,
            'code' => 200,
            'message' => null,
            'errors' => [],
            'data' => [],
            'meta' => null,
        );
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function get($key) {
        return $this->data[$key];
    }

    public function remove($key) {
        unset($this->data[$key]);
    }

    public function setStatus($value, $status) {
        $this->status = $value;
        $this->set('code', $value);
        $this->set('status', $status);
    }

    public function header($key = null, $value = null) {
        if(is_null($key) && is_null($value)) {
            return $this->headers;
        }
        if(is_null($value)) {
            $this->headers = $key;
        } else {
            $this->headers[$key] = $value;
        }
    }

    public function response($status = 200) {
        return response()
            // ->withHeaders($this->headers)
            ->json($this->data, $this->status);
    }

}

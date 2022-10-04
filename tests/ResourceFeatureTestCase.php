<?php
namespace Tests;

use Illuminate\Testing\Fluent\AssertableJson;

trait ResourceFeatureTestCase
{
    // NOTE: map public routes
    // public $publicMethods = [];

    public static $dataId;
    public function getId() {
        return self::$dataId;
    }

    public function setId($value) {
        self::$dataId = $value;
    }

    private static $dataIdTest;
    public static function setDataIdTest($value): void
    {
        self::$dataIdTest = $value;
    }

    public static function getDataIdTest(): string
    {
        return self::$dataIdTest;
    }

    protected function isMethodPublic($method) {
        try {
            if(!isset($this->publicMethods)) {
                return false;
            }
            return $this->publicMethods[$method];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function testSearchable()
    {
        $request = $this;
        if(!$this->isMethodPublic('index')){
            $request = $request->withHeaders([
                'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
            ]);
        }
        $response = $request->get($this->endpoint);

        $response
        ->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
            $json
            ->whereType("version", "string")
            ->whereType("api_version", "string")
            ->whereType("status", "string")
            ->whereType("collection", "string")
            ->whereType("code", 'integer')
            ->whereType("message", "string")
            ->whereType("data", 'array')
            ->whereType('errors', 'array')
            ->whereType('meta', 'array')
            ->etc()
        );
    }

    public function testStorableNotAuthorized()
    {
        $response = $this->postJson($this->endpoint, $this->postData);
        $response
        ->assertStatus(403);
    }

    public function testStorableInvalid()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->postJson($this->endpoint, []);

        $response
        ->assertStatus(400);
    }

    public function testStorableSuccess()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->postJson($this->endpoint, $this->postData);

        $data = $response->getData();
        $this->idDataCreated = $data->data->id;
        $this->setId($this->idDataCreated);

        $response
        ->assertStatus(201);
    }

    public function testShowableSuccess()
    {
        $request = $this;
        if(!$this->isMethodPublic('index')){
            $request = $request->withHeaders([
                'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
            ]);
        }
        $response = $request->get("{$this->endpoint}/{$this->getId()}");

        $response
        ->assertStatus(200);
    }

    public function testShowableNotFound()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->get($this->endpoint .'/'. uniqid());

        $response
        ->assertStatus(404);
    }

    public function testUpdatableNotAuthorized()
    {
        $response = $this->put("{$this->endpoint}/{$this->getId()}", []);

        $response
        ->assertStatus(403);
    }

    public function testUpdatableInvalid()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->putJson("{$this->endpoint}/{$this->getId()}",
            $this->putDataInvalid
        );

        $response
        ->assertStatus(400);
    }

    public function testUpdatableSuccess()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->putJson("{$this->endpoint}/{$this->getId()}",
            $this->putDataValid
        );

        $response
        ->assertStatus(200);
    }

    public function testPatchableNotAuthorized()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->patchJson("{$this->endpoint}/{$this->getId()}",
            $this->putDataValid
        );

        $response
        ->assertStatus(403);
    }

    public function testPatchableInvalid()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->patchJson("{$this->endpoint}/{$this->getId()}",
            $this->putDataInvalid
        );

        $response
        ->assertStatus(400);
    }

    public function testPatchableSuccess()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->patchJson("{$this->endpoint}/{$this->getId()}",
            $this->putDataValid
        );

        $response
        ->assertStatus(200);
    }

    public function testDestroyableNotAuthorized()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->deleteJson("{$this->endpoint}/{$this->getId()}");

        $response
        ->assertStatus(403);
    }

    public function testDestroyableSuccess()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->deleteJson("{$this->endpoint}/{$this->getId()}");

        $response
        ->assertStatus(200);
    }

    public function testTrashableNotAuthorized()
    {
        $response = $this->get($this->endpoint .'/trash');

        $response
        ->assertStatus(403);
    }

    public function testTrashableAuthorized()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->get($this->endpoint.'/trash');

        $response
        ->assertStatus(200);
    }

    public function testTrashedableSuccess()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->get("{$this->endpoint}/{$this->getId()}/trashed");

        $response
        ->assertStatus(200);
    }

    public function testTrashedableNotFound()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->get($this->endpoint .'/'. uniqid() .'/trashed');

        $response
        ->assertStatus(404);
    }

    public function testRestorable()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->postJson("{$this->endpoint}/{$this->getId()}/restore");

        $response
        ->assertStatus(200);
    }

    public function testDeletable()
    {
        // NOTE: the data must be deleted (soft delete) before permanent deleted
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->deleteJson("{$this->endpoint}/{$this->getId()}");

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
        ])->deleteJson("{$this->endpoint}/{$this->getId()}/delete");

        $response
        ->assertStatus(200);
    }

    public function testImportable()
    {
        $this->assertTrue(true);
    }

    public function testExportable()
    {
        $this->assertTrue(true);
    }

    public function testReportable()
    {
        $this->assertTrue(true);
    }

}

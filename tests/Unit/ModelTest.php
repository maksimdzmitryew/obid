<?php

declare(strict_types=1);

namespace Tests\Unit;

use                                         App\Model;
use                                       Tests\TestCase;
use                             Illuminate\Http\Request;

use Mockery;
use App\Http\Controllers\TestController;
#use App\Http\Controllers\ControllerGuest AS TestController;

class ModelTest extends TestCase
{
    public function boot()
    {
        $this->withoutExceptionHandling();
    }

    /**
     * Number is formatted for human visually accepted in logs
     *
     * @test
     * @return void
     */
    public function numberIsFormattedForHumanVisuallyAcceptedInLogs() : void
    {
        $model = new Model();
        $f_value = 1234567.85;
        $this->assertEquals($model->formatNumber($f_value),      '1’234’568');
        $this->assertEquals($model->formatNumber($f_value, 2),   '1’234’567,85');
    }

    /**
     * Number is formatted for human visually accepted in logs
     *
     * @test
     * @return void
     */
    public function scopeFilter() : void
    {
        $this->assertTrue(true);
    }

    /**
     * parent model does not have value set for protected fields list
     *
     * @test
     * @return void
     */
    public function parentModelDoesNotHaveValueSetForProtectedFieldsList() : void
    {
        $model = new Model();
        $a_res = $model->getFields();
        $this->assertNull($a_res);
    }

    /**
     * variable is passed and available witin view
     *
     * @test
     * @return void
     */
/*
    public function controllercheck() : void
    {


$this->withoutExceptionHandling();
$response = $this->get(route('guest.viewtest'));
$this->assertTrue(isset($response->original));
dd($response->original instanceof View, gettype($response->original), $response);


*/
#
#dump($response);
#$response->assertViewIs('layouts.test');
#$response->assertViewHas('array');

#$response = $this->get('/');
#$response->assertViewHas('array');
#dd($response);
/*
#$response = $this->call('GET', 'unit/test');
#$response->assertViewHas('_env');
#dd($response);
#        $res = $this->action('GET', 'Wecome@index');
#        dd($res);

        $ctrl = new TestController();
        $request = new Request;
        $response = $ctrl->index($request);
dd($response);
#        $value = data_get($response, 'test_array');
#dd($view);
dd(gettype($value));#, $response->assertViewHas('array'));
        $response->assertViewHas('test_array');
        $f_value = 1234567.85;
        $this->assertEquals($model->formatNumber($f_value),      '1’234’568');
        $this->assertEquals($model->formatNumber($f_value, 2),   '1’234’567,85');

#        $response->assertViewHas('version');
        $response->assertContains('version');
    }
*/


    /**
     * Null value added to foreign key in array if not submitted but expected by model's fields
     *
     * @test
     * @return void
     */
    public function NullValueAddedToForeignKeyInArrayIfNotSubmittedButExpectedByModelsFields() : void
    {
        $model = new Model();
        $request = new Request;

        $s_name_field = 'page_id';
        $a_fields = ['order_id', $s_name_field, ];

        $request->merge([
            'order_id' => 123456789,
        ]);

        $this->assertEquals(count($request->only($s_name_field)), 0);
        $this->assertFalse(isset($request->only($s_name_field)[$s_name_field]));
        $model->addNullValuesFromForm($request, $a_fields);
        $this->assertEquals(count($request->only('order_id')), 1);
        $this->assertEquals(count($request->only($s_name_field)), 1);
        $this->assertEquals($request->only($s_name_field)[$s_name_field], null);
    }

    /**
     * Bool value added for published to array if not submitted
     *
     * @test
     * @return void
     */
    public function BoolValueAddedForPublishedToArrayIfNotSubmitted() : void
    {
        $model = new Model();
        $request = new Request;

        $s_name_field = 'published';

        $this->assertEquals(count($request->only($s_name_field)), 0);
        $model->addBoolsValuesFromForm($request);
        $this->assertEquals(count($request->only($s_name_field)), 1);
        $this->assertFalse($request->only($s_name_field)[$s_name_field]);
    }

    /**
     * spell namespace for model that is a module
     *
     * @test
     * @return void
     */
    public function spellNamespaceForModelThatIsAModule() : void
    {
        $model = new Model();
        $s_name = 'Test';

        $s_namespace = $model->getModelNameWithNamespace(strtolower($s_name));
        $this->assertEquals($s_namespace, '\Modules\\' . $s_name . '\\' . 'Database' . '\\' . $s_name);
    }

    /**
     * parent model does not have parent id set by default
     *
     * @test
     * @return void
     */
    public function parentModelDoesNotHaveParentIdSetBydefault() : void
    {
        $model = new Model();
        $a_res = $model->getIdTitleForParent('None', null, 'parent', [1]);
        $this->assertEquals($a_res, array());
    }

    /**
     * parent model does not have related model set by default
     *
     * @test
     * @return void
     */
    public function parentModelDoesNotHaveRelatedModelSetByDefault() : void
    {
        $model = new Model();
        $request = new Request;
        $a_res = $model->getIdTitle($request, NULL, 'None', NULL, [], [], TRUE, TRUE);
        $this->assertEquals($a_res, array());
    }

    /**
     * transform array variable into response object when storing item cases sql error
     *
     * @test
     * @return void
     */
    public function transformArrayVariableIntoResponseObjectForCompatibilityWithQuery() : void
    {
        $model = new Model();
        $a_response = [
                'error'     => true,
                'code'      => 111,
        ];
        $a_res = $model->makeResponse($a_response);

        $this->assertEquals(gettype($a_res), 'object');
        $this->assertTrue($a_res->original['error']);
        $this->assertEquals($a_res->original['code'], 111);
        $this->assertJson($a_res->getContent(), '{"error":true,"code":111}');
    }
}

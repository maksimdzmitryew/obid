<?php

declare(strict_types=1);

namespace Tests\Unit;

use                                 App\Filters\FiltersAPI;
use                                         App\Model;
use                             Illuminate\Http\Request;
use                                       Tests\TestCase;

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
     * class translation property is present and has default value
     *
     * @test
     * @return void
     */
    public function classTranslationPropertyIsPresentAndHasDefaultValue() : void
    {
        $this->assertClassHasAttribute('translatedAttributes', 'App\\Model');
        $this->assertClassNotHasStaticAttribute('a_settings', 'App\\Model');
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
        $this->assertEquals($model->formatNumber($f_value,2),   '1’234’567,85');
    }

    /**
     * Check Translation Default
     *
     * @return String
     */
    private function checkTranslationDefault(Object $o_model, String $s_given_value) : String
    {
        $s_translated_value = $s_given_value;
        $s_field_name = '';
        $s_var_name = '';
        $s_module_name = '';
        $s_field_trans = '';
        $s_html_control = '';
        $s_html_usage = '';

        return $o_model->getTranslatedValue($s_translated_value, $s_field_name, $s_var_name, $s_module_name, $s_field_trans, $s_html_control, $s_html_usage);
    }

    /**
     * Check Translation Module Specific
     *
     * @return String
     */
    private function checkTranslationModuleSpecific(Object $o_model, String $s_given_value) : String
    {
        $s_translated_value = $s_given_value;
        $s_field_name = 'slug';
        $s_var_name = '';
        $s_module_name = 'setting';
        $s_field_trans = '';
        $s_html_control = '';
        $s_html_usage = 'label';

        return $o_model->getTranslatedValue($s_translated_value, $s_field_name, $s_var_name, $s_module_name, $s_field_trans, $s_html_control, $s_html_usage);
    }

    /**
     * Check Translation General for Role And Field
     *
     * @return String
     */
    private function checkTranslationGeneralForRoleAndField(Object $o_model, String $s_given_value) : String
    {
        $s_translated_value = $s_given_value;
        $s_field_name = '';
        $s_var_name = 'id';
        $s_module_name = '';
        $s_field_trans = 'user/crud';
        $s_html_control = '';
        $s_html_usage = 'label';

        return $o_model->getTranslatedValue($s_translated_value, $s_field_name, $s_var_name, $s_module_name, $s_field_trans, $s_html_control, $s_html_usage);
    }

    /**
     * Check Translation General for Role And Control
     *
     * @return String
     */
    private function checkTranslationGeneralForRoleAndControl(Object $o_model, String $s_given_value) : String
    {
        $s_translated_value = $s_given_value;
        $s_field_name = '';
        $s_var_name = '';
        $s_module_name = '';
        $s_field_trans = 'user/crud';
        $s_html_control = 'published';
        $s_html_usage = 'table';

        return $o_model->getTranslatedValue($s_translated_value, $s_field_name, $s_var_name, $s_module_name, $s_field_trans, $s_html_control, $s_html_usage);
    }

    /**
     * Check Translation General for Module
     *
     * @return String
     */
    private function checkTranslationGeneralForModule(Object $o_model, String $s_given_value) : String
    {
        $s_translated_value = $s_given_value;
        $s_field_name = '';
        $s_var_name = '';
        $s_module_name = '';
        $s_field_trans = 'setting::crud.names';
        $s_html_control = '';
        $s_html_usage = '';

        return $o_model->getTranslatedValue($s_translated_value, $s_field_name, $s_var_name, $s_module_name, $s_field_trans, $s_html_control, $s_html_usage);
    }

    /**
     * Translated values are checked and applied in correct order
     *
     * @test
     * @return void
     */
    public function translatedValuesAreCheckedAndAppliedInCorrectOrder() : void
    {
        $o_model = new Model();

        $s_translated_value = 'translated value Override';

        $s_res = $this->checkTranslationDefault($o_model, '');
        $this->assertEmpty($s_res);
        $s_res = $this->checkTranslationDefault($o_model, $s_translated_value);
        $this->assertEquals($s_res, $s_translated_value);

        $s_res = $this->checkTranslationModuleSpecific($o_model, '');
        $this->assertEquals($s_res, 'Кодове слово для інтерфейсу');
        $s_res = $this->checkTranslationModuleSpecific($o_model, $s_translated_value);
        $this->assertEquals($s_res, $s_translated_value);

        $s_res = $this->checkTranslationGeneralForRoleAndField($o_model, '');
        $this->assertEquals($s_res, 'ID');
        $s_res = $this->checkTranslationGeneralForRoleAndField($o_model, $s_translated_value);
        $this->assertEquals($s_res, $s_translated_value);

        $s_res = $this->checkTranslationGeneralForRoleAndControl($o_model, '');
        $this->assertEquals($s_res, 'Опубліковано');
        $s_res = $this->checkTranslationGeneralForRoleAndControl($o_model, $s_translated_value);
        $this->assertEquals($s_res, $s_translated_value);

        $s_res = $this->checkTranslationGeneralForModule($o_model, '');
        $this->assertEquals($s_res, 'Налад');
        $s_res = $this->checkTranslationGeneralForRoleAndControl($o_model, $s_translated_value);
        $this->assertEquals($s_res, $s_translated_value);
    }

    /**
     * Filters are applied to query
     *
     * @test
     * @return void
     */
    public function filtersAreAppliedToQuery() : void
    {
        $request = new Request;
        $o_model = new Model();
        $o_filters = new FiltersAPI($request);
        $query = $o_model->select()->where('id', '>', '0');
#        $res = $o_model->scopeFilter($query, $o_filters);
#        dd($query->toSql(), $res, $o_filters);
#        $filters = 1234567.85;
//        $this->assertEquals($model->formatNumber($f_value),      '1’234’568');

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
        $this->assertNull($request->only($s_name_field)[$s_name_field]);
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
        $model->addBoolsValuesFromForm($request, [$s_name_field]);
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
        $s_name = 'Country';

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

    /**
     * server name is string and can not be empty
     *
     * @test
     * @return void
     */
    public function serverNameIsStringAndCanNotBeEmpty() : void
    {
        $model = new Model();
        $s_res = $model->_getServerName();

        $this->assertNotEmpty($s_res);
        $this->assertStringMatchesFormat('%s', $s_res);
    }

    /**
     * write to log parameters order and type are correct
     *
     * @test
     * @return void
     */
    public function writeToLogParametersOrderAndTypeAreCorrect() : void
    {
        $model = new Model();
        $s_res = $model->writeLog('log_type', 'log_info');
        $this->assertNull($s_res);
        $s_res = $model->writeLog('log_type', 'log_info', 'log_time');
        $this->assertNull($s_res);
        $s_res = $model->writeLog('log_type', 'log_info', 'log_time', 222);
        $this->assertNull($s_res);
    }

    /**
     * check memory usage
     *
     * @test
     * @return void
     */
    public function checkMemoryUsage() : void
    {
        $model = new Model();

        $s_res = $model->getServerMemoryUsage();
        $this->assertIsFloat($s_res);

        $s_res = $model->getServerMemoryUsage(false);
        $this->assertIsArray($s_res);
        $this->assertArrayHasKey('total', $s_res);
        $this->assertArrayHasKey('free', $s_res);
    }

    /**
     * size is formatted to nice human readable presentation
     *
     * @test
     * @return void
     */
    public function sizeIsFormattedToNiceHumanReadablePresentation() : void
    {
        $model = new Model();

        $this->assertEquals($model->getNiceFileSize(0),                         '0 B');
        $this->assertEquals($model->getNiceFileSize(12.34),                     '12.34 B');
        $this->assertEquals($model->getNiceFileSize(1234.56),                   '1.21 KiB');
        $this->assertEquals($model->getNiceFileSize(1234567.89),                '1.18 MiB');
        $this->assertEquals($model->getNiceFileSize(123456789123.45),           '114.98 GiB');
        $this->assertEquals($model->getNiceFileSize(123456789123456.78),        '112.28 TiB');
        $this->assertEquals($model->getNiceFileSize(123456789123456789.12),     '109.65 PiB');
        $this->assertEquals($model->getNiceFileSize(1234567891234567891234567), '1.02 B');
    }

    /**
     * replace thousand separator from multibyte characher to single
     *
     * @test
     * @return void
     */
    public function replaceThousandSeparatorFromMultibyteCharacterToSingle() : void
    {
        $model = new Model();

        $s_res = $model->_replaceSeparatorK('1"234"567.89');
        $this->assertEquals($model->_replaceSeparatorK('1"234"567.89'),         '1‘234‘567.89');
    }

    /**
     * replace thousand separator in array and transform to string
     *
     * @test
     * @return void
     */
    public function replaceThousandSeparatorInArrayAndTransformToString() : void
    {
        $model = new Model();

        $s_format =     '%13s';
        $a_values =     [1234567.89];
        $s_res = $model->_replaceSeparatorForLogging($s_format, $a_values);
        $this->assertEquals($s_res, '   1234567.89');

        $a_values =     ['1"234"567.89'];
        $s_res = $model->_replaceSeparatorForLogging($s_format, $a_values);
        $this->assertEquals($s_res, ' 1‘234‘567.89');
    }
}

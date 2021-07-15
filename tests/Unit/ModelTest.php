<?php

declare(strict_types=1);

namespace Tests;

use                                         App\Model;
use                                       Tests\TestCase;
use                             Illuminate\Http\Request;

class ModelTest extends TestCase
{
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
}

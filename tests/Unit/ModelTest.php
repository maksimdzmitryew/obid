<?php

namespace Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model;

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
}

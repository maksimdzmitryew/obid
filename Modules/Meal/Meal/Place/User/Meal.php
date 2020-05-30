<?php

namespace Modules\Meal\User;

use Modules\Meal\Database\Meal as Model;

class Meal extends Model
{
	public $translationModel = '\Modules\Meal\Database\MealTranslation';
}

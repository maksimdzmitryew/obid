<?php

namespace Modules\City\Guest;

use Modules\City\Database\City as Model;

class City extends Model
{
	public $translationModel = '\Modules\City\Database\CityTranslation';
}

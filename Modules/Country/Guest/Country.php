<?php

namespace Modules\Country\Guest;

use Modules\Country\Database\Country as Model;

class Country extends Model
{
	public $translationModel = '\Modules\Country\Database\CountryTranslation';
}

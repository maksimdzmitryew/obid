<?php

namespace Modules\Place\API;

use Modules\Place\Database\Place as Model;

class Place extends Model
{
	public $translationModel = '\Modules\Place\Database\PlaceTranslation';
}

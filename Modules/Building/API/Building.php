<?php

namespace Modules\Building\API;

use Modules\Building\Database\Building as Model;

class Building extends Model
{
	public $translationModel = '\Modules\Building\Database\BuildingTranslation';
}

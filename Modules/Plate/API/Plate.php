<?php

namespace Modules\Plate\API;

use Modules\Plate\Database\Plate as Model;

class Plate extends Model
{
	public $translationModel = '\Modules\Plate\Database\PlateTranslation';
}
<?php

namespace Modules\Mark\API;

use Modules\Mark\Database\Mark as Model;

class Mark extends Model
{
	public $translationModel = '\Modules\Mark\Database\MarkTranslation';
}

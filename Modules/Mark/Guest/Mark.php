<?php

namespace Modules\Mark\Guest;

use Modules\Mark\Database\Mark as Model;

class Mark extends Model
{
	public $translationModel = '\Modules\Mark\Database\MarkTranslation';
}

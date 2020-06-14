<?php

namespace Modules\Course\API;

use Modules\Course\Database\Course as Model;

class Course extends Model
{
	public $translationModel = '\Modules\Course\Database\CourseTranslation';
}

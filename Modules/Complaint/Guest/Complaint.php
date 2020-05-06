<?php

namespace Modules\Complaint\Guest;

use Modules\Complaint\Database\Complaint as Model;

class Complaint extends Model
{
	public $translationModel = '\Modules\Complaint\Database\ComplaintTranslation';
}

<?php

namespace Modules\Page\Guest;

use Modules\Page\Database\Page as Model;

class Page extends Model
{
	public $translationModel = '\Modules\Page\Database\PageTranslation';
}

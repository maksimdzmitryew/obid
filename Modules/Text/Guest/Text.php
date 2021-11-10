<?php

namespace Modules\Text\Guest;

use                    Modules\Text\Database\Text as Model;

class Text extends Model
{
	public $translationModel = '\Modules\Text\Database\TextTranslation';
}

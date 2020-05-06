<?php

namespace Modules\Style\User;

use               Modules\Style\Database\Style          as DBStyle;

class Style extends DBStyle
{
	public $translationModel = '\Modules\Style\Database\StyleTranslation';
}

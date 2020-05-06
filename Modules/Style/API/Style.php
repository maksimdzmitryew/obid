<?php

namespace Modules\Style\API;

use               Modules\Style\Database\Style          as DBStyle;

class Style extends DBStyle
{
	public $translationModel = '\Modules\Style\Database\StyleTranslation';
}

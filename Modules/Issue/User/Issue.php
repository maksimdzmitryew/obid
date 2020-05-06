<?php

namespace Modules\Issue\User;

use Modules\Issue\Database\Issue as Model;

class Issue extends Model
{
	public $translationModel = '\Modules\Issue\Database\IssueTranslation';
}

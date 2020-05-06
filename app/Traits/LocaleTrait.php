<?php

namespace App\Traits;

use                       Illuminate\Support\Carbon;
use               Illuminate\Support\Facades\File;
use                                          Cookie;

trait LocaleTrait
{
	/**
	 * Update configs with actual data of available locales basing on translations present in directoris of "lang" folder
	 *
	 * @return void
	 */
	private function _L10N2config() : void
	{
		$s_path = base_path().'/resources/lang';
		$a_files = File::directories($s_path);
		$a_files = File::allFiles($s_path);
		$a_dirs = [];
		$a_L10N = [];

		foreach ($a_files as $o_file)
		{
			$s_abbr = $o_file->getRelativePath();

			if (strlen($s_abbr) != 2)
				continue;

			if ($o_file->getFilename() == 'app.php')
			{
				$a_tmp = include($o_file->getPathname());
				if (isset($a_tmp['lang']))
					$a_dirs[$s_abbr] = $a_tmp['lang'];
			}
			if(!isset($a_dirs[$s_abbr]))
				$a_dirs[$s_abbr] = NULL;
		}

		$locale = Cookie::get('lang');

		if (is_null($locale))
			$locale = app()->getLocale();
		if (is_null($locale))
			$locale = session('lang', config('app.fallback_locale'));
		if (!array_key_exists($locale, $a_dirs))
			$locale = config('app.fallback_locale');

		app()->setLocale($locale);
		setlocale(LC_TIME, $locale);
		Carbon::setLocale($locale);

		foreach ($a_dirs as $s_abbr => $s_name)
		{
			if (!is_null($a_dirs[$s_abbr]))
				$a_L10N[$s_abbr] = $a_dirs[$s_abbr];
			else
				$a_L10N[$s_abbr] = mb_strtoupper($s_abbr);
		}

		config(['translatable' => [
					'locales' => array_keys($a_L10N),
					'names' => $a_L10N,
				]]);
	}
}
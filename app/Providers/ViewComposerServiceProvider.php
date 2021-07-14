<?php

namespace App\Providers;

use                                  App\Traits\LocaleTrait;
use                                         App\Text;
use                  Illuminate\Support\Facades\App;
use                  Illuminate\Support\Facades\DB;
use                  Illuminate\Support\Facades\Schema;
use                             Illuminate\Http\Request;
use                          Illuminate\Support\ServiceProvider;


class ViewComposerServiceProvider extends ServiceProvider
{
	use LocaleTrait;
	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->_L10N2config();

		// TODO refactroring
		// app/Http/Controllers/Controller.php

		if (Schema::hasTable('settings'))
		{
			$o_settings	= app('App\Settings');
		}
		// TODO refactroring
		// for purpose of unit-testing only
		else
		{
			$o_settings =  new \stdClass();
		}
		// TODO refactroring
		// for purpose of unit-testing only
		if (!isset($o_settings->theme))
		{
			$a_modules = config('fragment.modules');
			$o_settings->theme = lcfirst($a_modules[0]);
			$o_settings->title = 'Feature Test';
			$o_settings->established = 2020;
		}

		if (isset($o_settings->theme))
		{
			$s_theme	= $o_settings->theme;
		}

		$a_version	= include( base_path(). '/version.php');

		\View::composer('*', function ($view) use ($a_version, $o_settings, $s_theme) {
			if ($route = \Request::route()) {
				$current_route_name = $route->getName();
			} else {
				$current_route_name = null;
			}

			# avoid css&js caching at dev environment
			if (config('app.env') == 'local')
			{
				$a_version->css = time();
				$a_version->js = time();
			}

			$view->with([
				'current_route_name'	=> $current_route_name,
				'localizations'			=> config('translatable.names'),
				'settings'				=> $o_settings,
				'theme'					=> $s_theme,
				'version'				=> $a_version,
			]);
		});

		\View::composer('public.*', function ($view) {
			$view->with([
				'texts_footer'          => $this->getTextsFooter(),
			]);
		});
	}

	/**
	 * Read footer data specific for language from DB
	 * @return array texts for fooer as associative array per codename as key and translated description as value
	 */
	protected function getTextsFooter()
	{
		$texts = array();
		$tmp = Text::select('texts.*')
			->leftJoin('text_translations', 'texts.id', '=', 'text_translations.text_id')
			->where('codename', 'LIKE', 'footer_%')
			->where(['text_translations.locale'  => App::getLocale()])
			->get();
		foreach ($tmp as $text)
		{
			$texts[$text->codename] = $text->description;
		}
		return $texts;
	}

	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}

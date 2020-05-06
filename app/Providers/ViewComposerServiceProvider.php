<?php

namespace App\Providers;

use                                      App\Text;
use                       Illuminate\Support\ServiceProvider;
use                          Illuminate\Http\Request;
use               Illuminate\Support\Facades\DB;
use               Illuminate\Support\Facades\App;
use                               App\Traits\LocaleTrait;

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

		$a_version	= include_once( base_path(). '/version.php');
		$s_theme	= config('app.theme') ?: '';

		\View::composer('*', function ($view) use ($a_version, $s_theme) {
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
				'settings'				=> app('App\Settings'),
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

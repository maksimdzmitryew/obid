<?php

namespace Modules\Complaint\Database;

use               Illuminate\Support\Facades\Mail;
use                                      App\Model;
use                  \Modules\Place\Database\Place;
use               Illuminate\Support\Facades\View;

class Complaint extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'place_id',
		'email',
		'published',
	];
	public $translatedAttributes = [];
	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
		'place_id'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> 'required|integer',
		],
	];

    public function place()
    {
        return $this->BelongsTo('Modules\Place\Database\Place');
    }


	/**
	 * Send complaints by email and create a copy in power panel
	 * @param Object	$o_place		The place with accesibility issues
	 * @param String	$s_issues		List of issues for the place
	 *
	 * @return void
	 */
	public static function sendIt(Object $o_place, String $s_issues) : void
	{
		$s_date		= date("m/d/Y");
		$s_title	= $o_place->title;
		$s_address	= $o_place->address;
		$s_descr	= $o_place->description;
		$a_issues	= $s_issues;
		$s_tmpl		= 'emails.complaint';
		$s_locale	= app()->getLocale();

		$a_from[0]	= [
						's_title'		=> 'ГРОМАДСЬКА ОРГАНІЗАЦІЯ «ДЕБАТИ ЗАРАДИ ЗМІН»',
						's_email'		=> 'debate4changes@gmail.com',
						's_phone'		=> '+38068 255 75 91',
						's_legal'		=> 'код: 40190259',
						's_subject'		=> 'Заява (звернення)',
						'a_position'	=> 'ПРЕЗИДЕНТА ГО «ДЕБАТИ ЗАРАДИ ЗМІН»',
						'a_position_who'=> 'Президент ГО «ДЕБАТИ ЗАРАДИ ЗМІН»',
						'a_name'		=> 'Крис Анни Сергіївни',
						'a_name_who'	=> 'Крис Анна Сергіївна',
						's_address'		=> 'м. Київ, вул. Інститутська, буд. 22/7, кв. 27, 01021',
						];
		$a_to[0]	= [

						's_title'		=> 'КИЇВСЬКА МІСЬКА ДЕРЖАВНА АДМІНІСТРАЦІЯ',
						's_address'		=> 'м. Київ, вул. Хрещатик, 36, 01044',
						'a_email'		=> ['zvernen@kmda.gov.ua','dsp@kmda.gov.ua',],
						];
		$a_to[1]	= [
						's_title'		=> 'МІНІСТЕРСТВО СОЦІАЛЬНОЇ ПОЛІТИКИ УКРАЇНИ',
						's_address'		=> 'м. Київ, вул. Еспланадна, 8/10, 01601',
						'a_email'		=> ['info@mlsp.gov.ua','zvernennya@mlsp.gov.ua',],
						];

		$s_email_from	= $a_from[0]['s_email'];
		$s_subj		 	= $a_from[0]['s_subject'];
		$s_name_from	= config('services.mail.name');

		if (config('app.env') == 'acceptance')
			$a_to[0]['a_email']			= [
											'anna.krys.od@gmail.com',
											'bogachenko.pavel@gmail.com',
											'max.dmitriev@activelex.com',
										];
		elseif (config('app.env') == 'local')
			$a_to[0]['a_email']			= [config('services.mail.from')];

		if (config('app.env') != 'production')
			$a_to[1]['a_email']			= $a_to[0]['a_email'];

		$a_params	=
				[
					's_date'		=> $s_date,
					's_title'		=> $s_title,
					's_address'		=> $s_address,
					's_descr'		=> $s_descr,
					'a_issues'		=> $a_issues,
					'a_from'		=> $a_from,
					'a_to'			=> $a_to,
				];

		$o_view			= View::make($s_tmpl, $a_params);
		$s_contents		= $o_view->render(); #$contents = (string) $view;

		$a_recipients	= [];
		$a_recipients[]	= ['email' => config('services.mail.from'), 'name' => config('services.mail.name'),];

		for ($i = 0; $i < count($a_to); $i++)
		{
			$a_data								= [];
			$a_data['published']				= 1;
			$a_data['place_id']					= $o_place->id;
			$a_data['email']					= $a_to[$i]['a_email'][0];
			$a_data[$s_locale]['title']			= $a_to[$i]['s_title'];
			$a_data[$s_locale]['description']	= $s_contents;
			$a_data[$s_locale]['address']		= $a_to[$i]['s_address'];

			for ($j = 0; $j < count($a_to[$i]['a_email']); $j++)
			{
				$a_recipients[] = [
							'email'		=> $a_to[$i]['a_email'][$j],
							'name'		=> $a_to[$i]['s_title'],
						];
			}

			self::create($a_data);
			$o_place->complaint_qty++;
		}

		for ($i = 0; $i < count($a_recipients); $i++)
		{
			$s_email_to = $a_recipients[$i]['email'];
			$s_name_to = $a_recipients[$i]['name'];

			Mail::send
			(
				$s_tmpl,
				$a_params,
				function($message) use ($s_subj, $s_email_to, $s_name_to, $s_email_from, $s_name_from)
				{
					$message
						->from($s_email_from, $s_name_from)
						->to($s_email_to, $s_name_to)
						->subject($s_subj)
					;
				}
			);
		}

	}

}

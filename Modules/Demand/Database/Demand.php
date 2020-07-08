<?php

namespace Modules\Demand\Database;

use                           Illuminate\Support\Carbon;
use       Illuminate\Database\Eloquent\Relations\HasMany;
use                                          App\Model;

class Demand extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'user_id',
		'plate_id',
		'published',
	];

	protected $a_form = [
		'published'		=> [
			'tab'		=> 'data',
			'field'		=> 'checkbox',
			'rules'		=> 'boolean',
			'default'	=>	TRUE,
		],
/*
		'plate_ids'		=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
*/
	];

	/**
	 * Get activity of user
	 * @param	Object		$o_user			user to check activity for
	 *
	 * @return	Array						specifically organised for easier presentation
	 */
	public static function getUserActivity(Object $o_user) : Array
	{
		$o_demands		= self::select('id')->whereUserId($o_user->id)->get('id', 'plate_id');
		$a_items		= [];
		foreach ($o_demands AS $k => $o_demand)
		{
			$o_plates	= $o_demand->plate;
			$a_tmp		= [];
			$i_tmp		= 0;
			foreach ($o_plates AS $k => $o_plate)
			{
				$a_items[$o_plate->date]['id'][]		= $o_plate->id;
				$a_items[$o_plate->date]['plate'][]		= $o_plate->meal->title;
				$a_items[$o_plate->date]['price'][]		= (int)$o_plate->price;
				$a_items[$o_plate->date]['position'][]	= $o_plate->position;
				if (!isset($a_items[$o_plate->date]['total']))
				{
					$a_items[$o_plate->date]['total']	= 0;
				}
				$a_items[$o_plate->date]['total']		+= $o_plate->price;
			}
		}
		return $a_items;
	}

	public function plate()
	{
		return $this->belongsToMany('Modules\Plate\Database\Plate');
	}

}

<?php

namespace Modules\City\API;

use                    Modules\City\Database\City as Model;
use                          Illuminate\Http\Request;
use                         \Illuminate\Http\Response;

class City extends Model
{
	public $translationModel = '\Modules\City\Database\CityTranslation';

	public static function changeOrder(Request $request, Object $o_env)
	{
		$i_qty_done = 0;
		$i_status = 201;
		$s_msg = trans('common/messages.order_entries_error');
		$a_order_sent = $request->order;
		$i_qty_sent = count($a_order_sent);

		if (!is_null($request->order))
		{
			$a_tmp = City::whereIn('id', $request->order)->get()->pluck('id', 'city_id')->toArray();
			$a_parent_ids = array_keys($a_tmp);

			/**
			 *	let's keep things simple for now
			 *	respond with error if parent city filter has not been applied
			 */
			if (count($a_parent_ids) > 1)
			{
				$i_status = 202;
				$s_msg = trans('common/messages.order_choose_parent');
			}

			/**
			 *	previous check passed ok
			 */
			if ($i_status == 201)
			{
				$a_tmp = City::whereIn('id', $request->order)->get()->pluck('order', 'id')->toArray();
				$a_order_current = array_keys($a_tmp);

				/**
				 *	let's keep things simple for now
				 *	not all child citys of this parent city were re-ordered in datatable city
				 */
				if (count($a_order_current) != $i_qty_sent)
				{
					$i_status = 203;
					$s_msg = trans('common/messages.order_qty_mistmatch');
				}
			}

			/**
			 *	all checks were a success
			 *
			 *	ready to chage the order
			 */
			if ($i_status == 201)
			{
				for ($i = 0; $i < $i_qty_sent; $i++)
				{
					/**
					 *	programatically order starts at 0
					 *	while for real life users such an approach might be confusing
					 */
					$i_order	= ($i + 1);
					/**
					 *	skip updated_at timestamp change
					 *	otherwise the datatable won't see the record when a filter is applied after this update
					 */
					$o_city = City::find($a_order_sent[$i]);
					$o_city->order = $i_order;
					$o_city->timestamps = FALSE;
					$o_city->save();

					$i_qty_done++;
				}
				$i_status = 200;
				$s_msg = trans('common/messages.order_entries_success', ['qty' => $i_qty_done]);
			}
		}

		return response(
			[
			'message' => $s_msg,
			'qty_sent' => $i_qty_sent,
			'qty_done' => $i_qty_done,
			],
			$i_status
		);
	}

}

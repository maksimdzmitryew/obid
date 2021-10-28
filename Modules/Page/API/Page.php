<?php

namespace Modules\Page\API;

use                    Modules\Page\Database\Page as Model;
use                          Illuminate\Http\Request;
use                         \Illuminate\Http\Response;

class Page extends Model
{
	public $translationModel = '\Modules\Page\Database\PageTranslation';

	public static function changeOrder(Request $request, Object $o_env)
	{
		$i_qty_done = 0;
		$i_status = 201;
		$s_msg = trans('common/messages.order_entries_error');
		$a_order_sent = $request->order;
		$i_qty_sent = count($a_order_sent);

		if (!is_null($request->order))
		{
			$a_tmp = Page::whereIn('id', $request->order)->get()->pluck('id', 'page_id')->toArray();
			$a_parent_ids = array_keys($a_tmp);

			/**
			 *	let's keep things simple for now
			 *	respond with error if parent page filter has not been applied
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
				$a_tmp = Page::whereIn('id', $request->order)->get()->pluck('order', 'id')->toArray();
				$a_order_current = array_keys($a_tmp);

				/**
				 *	let's keep things simple for now
				 *	not all child pages of this parent page were re-ordered in datatable page
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
					$o_page = Page::find($a_order_sent[$i]);
					$o_page->order = $i_order;
					$o_page->timestamps = FALSE;
					$o_page->save();

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

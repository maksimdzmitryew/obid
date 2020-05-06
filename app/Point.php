<?php

namespace App;

use App\Model;
use Modules\Issue\API\Issue;

class Point extends Model
{
	protected $connection = 'psc';
	protected $fillable = [
		'building_id',
		'report_id',
		'user_id',
		'published',
		'lat',
		'lng',
	];
	protected $a_form = [
		'building_id'	=> [
			'tab'		=> 'data',
			'field'		=> 'select',
			'rules'		=> '',
		],
		'published'		=> [
			'tab'		=> 'manage',
			'field'		=> 'checkbox',
			'rules'		=> '',
		],
	];

	/**
	 * Get list of issues specific to this point
	 * @param Request	$request		Data from request
	 * @param Integer	$id				point id
	 *
	 * @return Response	json instance of data for select2 expected format
	 */
	public static function getSpecificIssues($request, $id) : String
	{
		$i_design_id = Point::findOrFail($id)->design_id;
		$a_issue_ids = Design::findOrFail($i_design_id)->issue()->get()->pluck('id')->toArray();
		$a_issues = Issue::whereIn('id', $a_issue_ids);

		if (!is_null($request->search))
			 $a_issues = $a_issues->whereTranslationLike('title', '%' . $request->search .'%', app()->getLocale());

		$a_issues = $a_issues->get()->map( function($o_issue) {
			return ['id'=> $o_issue->id, 'text' => $o_issue->title];
		});
		return json_encode(['results'=>$a_issues]);
	}

	public function building()
	{
		return $this->belongsTo('App\Building');
	}
	public function report()
	{
		return $this->belongsToMany('App\Report');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}

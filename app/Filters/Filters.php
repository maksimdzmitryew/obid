<?php

namespace App\Filters;

use                          Illuminate\Http\Request;

abstract class Filters
{
	protected $request;
	protected $builder;
	protected $appLocale;

	protected $limit;
	protected $orderColumn;
	protected $orderDirection;

	protected $filteredCount;
	protected $filters = [];
	protected $columns = [];
	protected $perPage = 20;

	public function __construct(Request $request)
	{
		$this->request				= $request;
		$this->appLocale			= app()->getLocale();

		$this->limit				= $this->getLimit();
		$this->orderColumn			= $this->getOrderColumn();
		$this->orderDirection		= $this->getOrderDirection();
	}

	public function apply($builder)
	{
		$this->builder = $builder;

		foreach ($this->filters as $filter) {
			if (method_exists($this, $filter) && isset($this->request->filters[$filter])) {
				$this->$filter($this->request->filters[$filter]);
			}
		}

		$this->setFilteredCount();

		return $this->getQuery();
	}

	protected function getLimit()
	{
		if ($this->request->length)# && $this->request->length < 10) {
		{
			return $this->request->length;
		}

		return $this->perPage;
	}

	protected function getOrderColumn($s_default = 'id')
	{
		if (isset($this->request->columns[$this->request->order[0]['column']]['data'])) {
			return $this->request->columns[$this->request->order[0]['column']]['data'];
		}
		return $s_default;
	}

	protected function getOrderDirection()
	{
		if (isset($this->request->order[0]['dir'])) {
			return $this->request->order[0]['dir'];
		}

		return 'asc';
	}

	// Get basic query

	protected function getQuery()
	{
		return $this->builder->offset($this->request->start)
			->limit($this->limit)
			->orderBy($this->orderColumn, $this->orderDirection);
	}

	// Set count of filterd down rows

	protected function setFilteredCount()
	{
		$this->filteredCount = $this->builder->count();
	}

	// Get count of filtered down rows

	public function getFilteredCount()
	{
		return $this->filteredCount;
	}

	// Most common query scopes

	protected function id($id)
	{
		return $this->builder->whereId($id);
	}

	protected function _checkValidRange($s_date)
	{
		return ($s_date['from'] != 'Invalid date' && $s_date['to']  != 'Invalid date');
	}

	protected function created_at($created_at)
	{
		if ($this->_checkValidRange($created_at))
		{
			return $this->builder->whereBetween('created_at', [$created_at['from'], $created_at['to']]);
		}
	}

	protected function updated_at($updated_at)
	{
		if ($this->_checkValidRange($updated_at))
		{
			return $this->builder->whereBetween('updated_at', [$updated_at['from'], $updated_at['to']]);
		}
	}

	protected function published($published)
	{
		return $this->builder->wherePublished($published);
	}

}

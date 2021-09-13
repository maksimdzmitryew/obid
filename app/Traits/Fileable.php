<?php

namespace App\Traits;

use                                      Carbon\Carbon;
use                                         App\File;

trait Fileable
{
	private $_file;

	public function file()
	{
		return $this->morphOne('App\File', 'fileable')->where('type', 'doc')->withDefault();
	}

	public function files()
	{
		return $this->morphMany('App\File', 'fileable');
	}

	private function _cleanGarbage($request, Array $a_field_name) : void
	{
		$a_files_orphan = array();
		$a_files_ignore = array();

		# garbage collector
		# clean up uploaded files but yet not attached to any item in DB
		# older than 1 week ago
		$res = File::where('fileable_id', '=', NULL)->where('created_at', '<', Carbon::today()->subWeek())->get();

		if ($res->count() > 0)
			$a_files_orphan = array_merge($a_files_orphan, $res->map->id->toArray());

		for ($i = 0; $i < count($a_field_name); $i++)
		{
			$s_tmp		= $a_field_name[$i];
			if (!is_null($this->$s_tmp))
			{
				$a_files_ignore[] = (int)$this->$s_tmp;
			}
			if (!is_null($request->$s_tmp))
			{
				$a_files_ignore[] = (int)$request->$s_tmp;
			}
		}
		if ($this->files)
			$a_files_orphan = array_merge($a_files_orphan, $this->files->map->id->toArray());

		if (count($a_files_orphan) > 0)
		{
			# delete only files that are not in the array form submitted by user
			$a_files_orphan = array_diff($a_files_orphan, $a_files_ignore);
			# clean actual files
			# clean DB records
			foreach ($a_files_orphan as $value) {
				$this->_getFile($value)->delete();
			}
/*
			// what does this do?
			File::destroy($a_files_orphan);
*/
		}
	}

	public function processFiles($request, $s_file_type = 'file', $o_env)
	{
		$a_field_name	= $o_env->a_types['file'];

		if (empty($a_field_name))
		{
			$a_field_name   = ['file_id'];
		}

  		self::_cleanGarbage($request, $a_field_name);

		for ($i = 0; $i < count($a_field_name); $i++)
		{
			$s_tmp		= $a_field_name[$i];
			$this->_updateFile($request, $s_tmp);
		}
	}

	private function _getFile($file_id)
	{
		return $file_id ? File::find($file_id) : null;
	}

	private function _setFile($file_id)
	{
		$this->_file = $this->_getFile($file_id);
	}

	public function archive()
	{
		return $this->morphOne('App\File', 'fileable')->where('type', 'archive')->withDefault();
	}

	private function _updateFile($request, $s_name)
	{
		$b_del			= FALSE;
		$b_upd			= FALSE;
		$i_id			= NULL;
		$this->_file	= NULL;

		$curr_file		= $this->_getFile($this->$s_name);
		if ($curr_file)
		{
			$i_id		= $curr_file->id;
		}
        $new_file		= $this->_getFile($request->$s_name);
    # new item created
		$b_upd = $b_upd || (is_null($request->id));
    # exisiting item modified
		$b_upd = $b_upd || ($this->$s_name != $request->$s_name);

		if ($b_upd)
		{
			$this->attachFile($request, $s_name);
			if ($this->_file)
			{
				$i_id		= $this->_file->id;
			}
		}

		$b_del = $b_del || ($curr_file && !$request->$s_name);
		$b_del = $b_del || ($curr_file && $this->_file && $this->$s_name != $request->$s_name);
#dump('b_del='.($b_del ? 'TRUE' : 'FALSE'), $curr_file, $this->_file, $request->$s_name);
		if ($b_del)
		{
			$curr_file->delete();
			$i_id		= NULL;
		}

		$request->merge([
			$s_name => $i_id,
		]);
	}

	public function attachFile($request, $s_name)
	{
		$this->_setFile($request->$s_name);
		if ($this->_file) {
			$this->_file->fileable()->associate($this);
			$this->_file->save();
		}
	}
}

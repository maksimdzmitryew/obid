<?php

namespace App\Traits;

use App\File;
use Carbon\Carbon;
trait Imageable
{
    private $_file;

    public function image()
    {
        return $this->morphOne('App\File', 'fileable')->where('type', 'image')->withDefault();
    }

	public function images()
	{
		return $this->morphMany('App\File', 'fileable');
	}

    private function _getImageFile($image_id)
    {
        return $image_id ? File::find($image_id) : null;
    }

    private function _setImageFile($image_id)
    {
        $this->_file = $this->_getImageFile($image_id);
    }

    public function processImages($request, $s_image_type = 'image')
    {
#        dd($request->image_ids, $this->images, $this->image);#->id);

        $a_img = array();

        # garbage collector
        # clean up uploaded files but yet not attached to any item in DB
        # older than 1 week ago
        $res = File::where('fileable_id', '=', NULL)->where('created_at', '<', Carbon::today()->subWeek())->get();
        if ($res->count() > 0)
            $a_img = array_merge($a_img, $res->map->id->toArray());

#        if ($this->image->id)
#            $a_img = array_merge( $a_img, array($this->image->id) );

        if ($this->images)
            $a_img = array_merge($a_img, $this->images->map->id->toArray());

        if (count($a_img) > 0)
        {
            # delete only images that are not in the array form submitted by user
            if (isset($request->image_ids) && is_array($request->image_ids))
            {
                $a_img = array_diff($a_img, $request->image_ids);
            }
            #File::destroy($a_img);
            foreach ($a_img as $value) {
                $this->_getImageFile($value)->delete();
            }
        }

        if (!$request->image_ids) return null;

        $positions = array_flip($request->image_ids);

        File::whereIn('id', $request->image_ids)->get()
            ->each(function($file, $position) use ($request, $positions, $s_image_type) {

                #$this->_setImageFile($file->id);
#        dd($positions, $request->image_copyrights, $file->id);
#        isset($positions[$file->id]) ? $positions[$file->id] : 0

                $request->image_id = $file->id;
                $request->image_copyright = $request->image_copyrights[$file->id];
                $this->attachImage($request, $s_image_type, $positions[$file->id]);
/*
                $file->fileable()->associate($this);
                $file->position = $positions[$file->id];
                $file->type = $s_image_type;
                $file->save();
*/
            }
        );

        return $this;
    }

    public function updateImage($request, $s_image_type = 'image', $position = 0)
    {
        $b_del          = FALSE;
        $b_upd          = FALSE;

        $curr_image     = $this->_getImageFile($this->image->id);

        #$this->_setImageFile($request->image_id);

        $b_upd = $b_upd || ($this->image->id != $request->image_id);
        $b_upd = $b_upd || ($this->image->copyright != $request->image_copyright);
#        dd($b_upd, $request->image_id);
        #$b_upd = $b_upd && (!is_null($this->_file));
#dd($request->image_id);
        if ($b_upd)
        {
            $this->attachImage($request, $s_image_type, $position);
        }

        $b_del = $b_del || ($curr_image && !$request->image_id);
        $b_del = $b_del || ($curr_image && $this->_file && $curr_image->id != $this->_file->id);
        if ($b_del)
        {
            $curr_image->delete();
        }

        return $this;
    }

    public function attachImage($request, $s_image_type = 'image', $position = 0)
    {
        $this->_setImageFile($request->image_id);

        if ($this->_file) {
            $this->_file->fileable()->associate($this);
            $this->_file->type = $s_image_type;
            $this->_file->position = $position;
            $this->_file->copyright = $request->image_copyright;
            $this->_file->save();
        }
        return $this;
    }
}

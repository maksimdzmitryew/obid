<?php

namespace App\Traits;

use App\File;

trait Fileable
{
    public function file()
    {
        return $this->morphOne('App\File', 'fileable')->where('type', 'doc')->withDefault();
    }

    public function archive()
    {
        return $this->morphOne('App\File', 'fileable')->where('type', 'archive')->withDefault();
    }

    public function updateFile($file_id)
    {
        if ($this->file->id == $file_id) {
            return $this;
        }

        $old_file = $this->file->id ? File::find($this->file->id) : null;
        $new_file = $file_id ? File::find($file_id) : null;

        if ($old_file && ! $file_id) {
            $old_file->delete();
        } elseif ($new_file) {
            $new_file->fileable()->associate($this);
            $new_file->save();

            if ($old_file) {
                $old_file->delete();
            }
        }

        return $this;
    }

    public function updateArchive($file_id)
    {
        if ($this->archive->id == $file_id) {
            return $this;
        }

        $old_file = $this->archive->id ? File::find($this->archive->id) : null;
        $new_file = $file_id ? File::find($file_id) : null;

        if ($old_file && ! $file_id) {
            $old_file->delete();
        } elseif ($new_file) {
            $new_file->fileable()->associate($this);
            $new_file->save();

            if ($old_file) {
                $old_file->delete();
            }
        }

        return $this;
    }


    public function attachFile($file_id)
    {
        if ($file_id && $file = File::find($file_id)) {
            $file->fileable()->associate($this);
            $file->save();
        }

        return $this;
    }
}
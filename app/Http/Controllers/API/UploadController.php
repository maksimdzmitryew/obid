<?php

namespace App\Http\Controllers\API;

use App\File;
use Spatie\Image\Image as SpatieImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
	public function file(Request $request) : Array
	{
		$this->validate($request, [
			'file' => 'required|file'
		]);

		$a_types = [
			'archive' => [
				'7z',
				'rar',
				'zip',
			],
			'doc' => [
				'doc',
				'docx',
				'pdf',
			],
		];

		$o_file			= $request->file;
		$s_file_ext		= $o_file->guessExtension(); #getClientOriginalExtension
		$s_type			= 'doc';

		foreach($a_types as $s_file_type => $a_extensions) {
			if (array_search(strtolower($s_file_ext), $a_extensions) !== FALSE) {
				$s_type = $s_file_type;
				break;
			}
		}

		$today			= today();
		$s_file_url		= File::getFilePath($today);
		$s_file_path	= File::getRelativeStoragePath($today);
		$s_full_path	= Storage::putFile($s_file_path, $o_file);
		$s_file_name	= collect(explode('/', $s_full_path))->last();

		$a_file_data =
		[
			'type'						=> $s_type,
			'url'						=> $s_file_url . $s_file_name,
			'path'						=> $s_file_path . $s_file_name,
			'savedname'					=> $s_file_name,
			'title'						=> $o_file->getClientOriginalName(),
			'size'						=> $o_file->getSize(), #round($o_file->getSize() / 1024, 2)
		];

		if ($request->alt)
			$a_file_data['alt']			= $request->alt;
		if ($request->copyright)
			$a_file_data['copyright']	= $request->copyright;

		$a_file = File::create($a_file_data);
		$a_file['size'] = round($a_file['size']/1024, 2);

		return [
			'file'    => $a_file
		];
	}

	public function image(Request $request) : Array
	{
		$this->validate($request, [
			'image' => 'required|image'
		]);

		$sizes = [
			'small' => [
				'width' => 320,
				'height' => 240,
			],
			'medium' => [
				'width' => 1024,
				'height' => 768,
			],
		];

		$o_file			= $request->image;
		$s_image_ext	= $o_file->guessExtension();
		$s_type			= 'image';

		$today			= today();
		$s_file_url		= File::getFilePath($today);
		$s_image_path	= File::getRelativeStoragePath($today);

		$s_full_path	= Storage::putFile($s_image_path, $o_file);
		$s_file_name	= collect(explode('/', $s_full_path))->last();

		$a_tmp			= explode('.', $s_file_name);
		$s_image_hash	= $a_tmp[0];
		$image_manipulator = SpatieImage::load($o_file);

		foreach ($sizes as $size => $dimensions) {
			$image_name = $s_image_hash . '-' . $size . '.' . $s_image_ext;
			$images[$size] = $image_name;

			$image_manipulator->width($dimensions['width'])
				->height($dimensions['height'])
				->save(
					storage_path() . '/app/' . $s_image_path . $image_name
				);
		}

		$a_file_data =
		[
			'type'						=> 'image',
			'url'						=> $s_file_url . $s_file_name,
			'url_medium'				=> $s_file_url . $images['medium'],
			'url_small'					=> $s_file_url . $images['small'],
			'path'						=> $s_image_path . $s_file_name,
			'path_medium'				=> $s_image_path . $images['medium'],
			'path_small'				=> $s_image_path . $images['small'],
			'savedname'					=> $s_file_name,
			'title'						=> $o_file->getClientOriginalName(),
			'size'						=> $o_file->getSize(), #round($o_file->getSize() / 1024, 2)
		];

		if ($request->alt)
			$a_file_data['alt']			= $request->alt;
		if ($request->copyright)
			$a_file_data['copyright']	= $request->copyright;

		$a_file = File::create($a_file_data);
		$a_file['size'] = round($a_file['size']/1024, 2);

		return [
			'image'    => $a_file
		];
	}
}

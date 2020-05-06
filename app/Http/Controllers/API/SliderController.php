<?php

namespace App\Http\Controllers\API;

use App\File;
use App\Slide;
use App\Slider;
use App\Filters\SliderFilters;
use App\Http\Requests\SliderRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderApiRequest;

class SliderController extends Controller
{
    public function index(SliderApiRequest $request, SliderFilters $filters)
    {
        $sliders = Slider::filter($filters);

        return response([
            'draw'            => $request->draw,
            'data'            => $sliders->get(),
            'recordsTotal'    => Slider::count(),
            'recordsFiltered' => $filters->getFilteredCount(),
        ], 200);
    }

    public function store(SliderRequest $request)
    {
        $slider = Slider::create($request->only('name'));
        $this->dispatchSlides($request->slides, $slider->id);

        return response([], 200);
    }

    public function update(SliderRequest $request, Slider $slider)
    {
        $slider->update($request->only('name'));

        foreach ($slider->slides as $slide) {
            if ($image = $slide->image) {
                $image->fileable()->dissociate();
                $image->save();
            }
            $slide->delete();
        }

        $this->dispatchSlides($request->slides, $slider->id);

        return response([], 200);
    }

    public function destroy(DeleteRequest $request)
    {
        Slider::destroy($request->ids);

        return response([], 200);
    }

    protected function dispatchSlides($request_slides, $slider_id)
    {
        foreach ($request_slides as  $slide_data) {
            $slide = Slide::create([
                'slider_id' => $slider_id,
                'position' => $slide_data['position'],
                'en' => $slide_data['en'],
                'de' => $slide_data['de']
            ]);

            if ($image = File::find($slide_data['image_id'])) {
                $image->fileable()->associate($slide);
                $image->save();
            }
        }
    }
}

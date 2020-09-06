<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Requests\SlidersRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SliderController extends ApiController
{

    public function index()
    {
        $sliders = Slider::latest()->paginate(10);
        return $this->showDataResponse('sliders', $sliders);
    }

    public function store(SlidersRequest $request)
    {
        $slug = Str::slug($request->title);
        if ($request->hasFile('photo')) {

            $image = $request->file('photo');
            $image_name = CommonController::fileUploaded(
                $slug, false, $image, 'sliders', ['width' => '1600', 'height' => '1066']
            );
            $request['image'] = $image_name;
        }

        $request['created_by'] = Auth::id() ?? 1;
        $request['updated_by'] = Auth::id() ?? 1;
        $request['slug'] = $request->title . '-' . time();
        $request['status'] = $request->status ? 1 : 0;

        $only = $request->only('title', 'slug', 'image', 'created_by', 'updated_by', 'status');

        $slider = Slider::create($only);

        return $this->showDataResponse('slider', $slider, 201, 'Slider created success');
    }

    public function show($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        if ($slider) {
            return $this->showDataResponse('slider', $slider, 200);
        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }

    public function update(SlidersRequest $request, $slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        if ($slider) {
            $slug = Str::slug($request->title);
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $image_name = CommonController::fileUploaded(
                    $slug,
                    false,
                    $image,
                    'sliders',
                    ['width' => '1600', 'height' => '1066',],
                    $slider->image
                );
                $request['image'] = $image_name;
            } else {
                $request['image'] = $slider->image;
            }
            $request['updated_by'] = Auth::id() ?? 0;

            $only = $request->only('title', 'image', 'updated_by');

            $slider->update($only);
            return $this->showDataResponse('slider', $slider, 200);

        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }

    public function destroy($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        if ($slider) {
            if ($slider->image) {
                CommonController::deleteImage('sliders', $slider->image);
            }
            $slider->delete();
            return $this->successResponse('Slider deleted success');
        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }


    public function changeStatus($slug)
    {
        $slider = Slider::where('slug', $slug)->first();
        if ($slider) {
            $slider->status = !$slider->status;
            $slider->save();
            return $this->successResponse('Slider status successfully change');
        } else {
            return $this->errorResponse('Not Found', 404);
        }
    }

    public function liveSearchSlider(Request $request)
    {
        $slider = Slider::where('title', 'like', '%' . $request->text . '%')
            ->paginate(10);
        return $this->showDataResponse('sliders', $slider);
    }

}

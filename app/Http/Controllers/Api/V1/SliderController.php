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
        $sliders = Slider::paginate(10);
        return $this->showDataResponse('sliders', $sliders);
    }

    public function store(SlidersRequest $request)
    {
        $slug = Str::slug($request->title);
        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $image_name = CommonController::fileUploaded(
                $slug, false, $image, 'sliders', ['width' => '1600', 'height' => '1066']
            );
            $request['image'] = $image_name;
        }
        $request['created_by'] = Auth::id() ?? 0;
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only = $request->only('title', 'image', 'created_by', 'updated_by', 'status');

        $slider = Slider::create($only);

        return $this->showDataResponse('slider', $slider, 201);
    }

    public function show(Slider $slider)
    {
        return $this->showDataResponse('slider', $slider, 200);
    }

    public function update(SlidersRequest $request, Slider $slider)
    {
        $slug = Str::slug($request->title);
        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $image_name = CommonController::fileUploaded(
                $slug, false, $image, 'sliders', ['width' => '1600', 'height' => '1066',], $slider->image
            );
            $request['image'] = $image_name;
        } else {
            $request['image'] = $slider->image;
        }
        $request['updated_by'] = Auth::id() ?? 0;
        $request['status'] = $request->status ?? 0;

        $only = $request->only('title', 'image', 'updated_by', 'status');

        $slider->update($only);

        return $this->showDataResponse('slider', $slider, 201);
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            CommonController::deleteImage('sliders', $slider->image);
        }
        $slider->delete();
        return $this->successResponse('Slider deleted success');
    }
}

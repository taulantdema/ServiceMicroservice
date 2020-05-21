<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent;
use Illuminate\Facades\Storage;
use DB;


class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'category_id' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            //filename permban emrin e file , edhe path info
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            //extension permaban ext(ex.jpeg,png)/filename veq emrin orgjinal qysh ja len
            $extension = $request->file('image')->getClientOriginalExtension();
            //filenametoStore eshte variabla e fundit e cila permban emrin e file psh taulantimage-kohen-extention psh jpeg.
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $service = new Service([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $fileNameToStore,
            'subcategory_id' => $request->subcategory_id,

        ]);
        $service->save();
        return response()->json([
            'message' => 'Successfully created Service!'
        ], 201);
    }

    public function findByUser(Request $request){
        $id = $request->get('id');
        return Service::where('user_id',$id)->get();
    }

    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'category_id' => 'required',
//            'user_id'=>'required',
            'price' => 'required',
            'description' => 'required'
        ]);
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            //filename permban emrin e file , edhe path info
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            //extension permaban ext(ex.jpeg,png)/filename veq emrin orgjinal qysh ja len
            $extension = $request->file('image')->getClientOriginalExtension();
            //filenametoStore eshte variabla e fundit e cila permban emrin e file psh taulantimage-kohen-extention psh jpeg.
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $service = new Service([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $fileNameToStore,

        ]);
        $service = Service::find($id);
        $service->save();
        return response()->json([
            'message' => 'Successfully created Service!'
        ], 201);
    }
    public function show(Service $service){
        return response()->json([
            'service' => $service,
        ], 201);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Successfully deleted Service!'
        ], 201);
    }

    public function index()
    {
        $service = Service::all();
        return $service;
    }
    public function update(Request $request,Service $service){
        $this->validate($request, [
            'name' => 'string',
            'description'=>'string',
            'image'=>'string',
//            'price'=>'double'

        ]);
        if ($request->hasFile('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            //Get just filename
            //filename permban emrin e file , edhe path info
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext
            //extension permaban ext(ex.jpeg,png)/filename veq emrin orgjinal qysh ja len
            $extension = $request->file('image')->getClientOriginalExtension();
            //filenametoStore eshte variabla e fundit e cila permban emrin e file psh taulantimage-kohen-extention psh jpeg.
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $serviceToUpdate = $service;
        $serviceToUpdate->name = request()->input("name");
        $serviceToUpdate->image = request()->input("image");
//        $serviceToUpdate->name = request()->input("name");
        $serviceToUpdate->price = request()->input("price");
        $serviceToUpdate->description = request()->input("description");
        $serviceToUpdate->save();
        return response()->json([
            'message' => 'Updated!',
            'service'=> $serviceToUpdate
        ], 201);

    }



}

<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\AddGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
  
        $galleries = Gallery::with('comments','images', 'user')->get();

        return response()->json($galleries);
    }


    public function myGalleries()
    {
  
        $galleries = Auth::user()->galleries()->get();

        return response()->json($galleries);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddGalleryRequest $request)
    {
        $data = $request->validated();
         
       $gallery = Auth::user()->galleries()->create($data);

       foreach ($request->images_url as $imageUrl) {
        $gallery->images()->create(['image_url' => $imageUrl]);
      }

      return response()->json($gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {   

        $data= Gallery::with('user','comments','images')->where('id',$gallery->id)->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request)
    {
        $data = $request->validated();
        $galleryToUpdate= Gallery::findOrFail($data['id']);
        $data['images_url'] = serialize($data['images_url']);
    
        $galleryToUpdate->title= $data['title'];
        $galleryToUpdate->description= $data['description'];
        $galleryToUpdate->images_url= $data['images_url'];
        $galleryToUpdate->save();

        return response()->json($galleryToUpdate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json($gallery);
    }
}

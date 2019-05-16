<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FieldStoreRequest;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldStoreRequest $request)
    {
        $input = $request->except('foto');
        $field = Field::create($input);

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();

            $extensions = array('jpg', 'jpeg', 'png');
            if(in_array($extension, $extensions)){
                // SAve image to the images folder
                $name = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/', $name);

                // SAve photo in the table
                $photo = new Photo();
                $photo->ruta = $name;
                $photo->cid = $field->cid;
                $photo->save();
            }
        }
        return response()->json(['exito'=> 'Cancha creada'], 200);
    }

    public function showPlaces()
    {
        $fields = Field::all();
        $photos = Photo::all();

        $total = array();
        foreach ($fields as $field) {
            foreach($photos as $photo){
                if($field->cid == $photo->cid){
                    $field->ruta = $photo->ruta;
                    $total[] = array($field);
                    unset($photo);
                    break;
                }
            }
        }
        return response()->json(['canchas'=> $total], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show($cid)
    {
        $field = Field::where('cid',$cid)->firstOrFail();
        return response()->json(['cancha' => $field], 200);
    }

    public function edit($cid)
    {
        $field = Field::where('cid',$cid)->firstOrFail();
        return response()->json(['cancha' => $field], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $cid)
    {
        Field::findOrFail($cid)
        ->update($request->except('foto'));

        $newField = Field::where('cid',$cid)->firstOrFail();

        if($request->has('foto')){
            $file = $request->foto;
            $extension = $file->getClientOriginalExtension();

            $extensions = array('jpg', 'jpeg', 'png');
            if(in_array($extension, $extensions)){
                // Save image to the images folder
                $name = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/', $name);

                // Update photo in the table
                if(Photo::where('cid', $cid)->first()){
                    Photo::findOrFail($cid)
                    ->update(array('ruta' => $name));
                }else{
                    $photo = new Photo();
                    $photo->cid = $cid;
                    $photo->ruta = $name;
                    $photo->save();
                }
            }
        }

        if(Photo::where('cid',$cid)->first()){
            $photo = Photo::where('cid',$cid)->first();
            $newField->ruta = $photo->ruta;
        }

        return response()->json(['cancha' => $newField], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid)
    {
        $photo = Photo::where('cid',$cid)->first();
        $path = $photo->ruta;
        if(Photo::destroy($cid)){
            $file_path = public_path() . '/images/' . $path;
            \File::delete($file_path);
        }
        if(Field::destroy($cid)){
            return response()->json(['exito' => 'La cancha se ha eliminado correctamente'], 200);
        }
    }
}

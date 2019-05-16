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
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['name'] =  $user->name;
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
                    $field->path = $photo->path;
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
    public function show(Field $field)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }
}

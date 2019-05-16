<?php

namespace App\Http\Controllers;

use App\Field;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FieldStoreRequest;
use Illuminate\Support\Facades\Auth;
use Validator;

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
        $input = $request->all();
        $field = Field::create($input);
        // $success['token'] =  $user->createToken('MyApp')->accessToken;
        // $success['name'] =  $user->name;
        if($request->hasFile("image")){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();

            $extensions = array('jpg', 'jpeg', 'png');
            if(in_array($extension, $extensions)){
                $filename = time().$file->getClientOriginalName();
                Storage::disk('local')->putFileAs(
                    'images/'.$filename,
                    $file,
                    $filename
                );
                $photo = new Photo();
                $photo->path = $filename;
                $photo->cid = $field->cid;
                $photo->save();
            }
        }
        return response()->json(['success'=> 'User created'], 200);
    }

    public function showPlaces()
    {
        $fields = Field::get();
        $photo = Photo::whereIn('cid', $fields)->get();
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

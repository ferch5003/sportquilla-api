<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\Reservation;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
        $q = Field::where('cid', '=', $request->cid)
        ->whereTime('hora_inicio', '<=', \Carbon\Carbon::parse($request->hora_inicio))
        ->whereTime('hora_final', '>=', \Carbon\Carbon::parse($request->hora_inicio))
        ->whereTime('hora_inicio', '<=',\Carbon\Carbon::parse($request->hora_final))
        ->whereTime('hora_final', '>=', \Carbon\Carbon::parse($request->hora_final))
        ->get();
        if ($q->count()) {
            $reservation = Reservation::where('cid', '=', $request->cid)->first();

            if($reservation){
                return response()->json(['error' => 'No se puede hacer la reserva'], 200);
            }else{
                $newReservation = Reservation::create($request->except(['hora_inicio', 'hora_final']));
                return response()->json(['reserva' => $newReservation], 200);
            }
        }
        return response()->json(['error' => 'No se puede realizar la reserva'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::where('id',$id)->first();
        return response()->json(['reserva' => $reservation], 200, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reservation = Reservation::where('id',$id)->first();
        return response()->json(['reserva' => $reservation], 200, $headers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Reservation::destroy($id)){
            return response()->json(['exito' => 'La reserva se ha eliminado correctamente'], 200);
        }
    }
}

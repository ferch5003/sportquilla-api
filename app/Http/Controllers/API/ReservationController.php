<?php

namespace App\Http\Controllers\API;

use App\Field;
use App\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $q = Field::where('cid', '=', $request->cid);
        $q->where(function ($fq) {
            $fq->where(function ($fq) {
                $fq->where(function ($fq) {
                    $fq->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_final]);
                });
                $fq->orWhere(function ($fq) {
                    $fq->whereBetween('hora_final', [$request->hora_inicio, $request->hora_final]);
                });
            });
            $fq->orWhere(function ($fq) {
                $fq->where('hora_inicio', '<', $request->hora_inicio);
                $fq->where('hora_final', '>', $request->hora_final);
            });
        });
        $q->count('*');
        if ($q) {
            $q = Reservation::where('cid', '=', $request->cid);
            $q->where(function ($fq) {
                $fq->where(function ($fq) {
                    $fq->where(function ($fq) {
                        $fq->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_final]);
                    });
                    $fq->orWhere(function ($fq) {
                        $fq->whereBetween('hora_final', [$request->hora_inicio, $request->hora_final]);
                    });
                });
                $fq->orWhere(function ($fq) {
                    $fq->where('hora_inicio', '<', $request->hora_inicio);
                    $fq->where('hora_final', '>', $request->hora_final);
                });
            });
            $q->count('*');
            Reservation::create($request->except(['hora_inicio', 'hora_final']));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
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
    public function destroy(Reservation $reservation)
    {
        //
    }
}

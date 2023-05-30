<?php

namespace App\Http\Controllers;

use App\Models\consultations;
use App\Models\Medicals;
use App\Models\Societies;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $request->query('token');
        $society = Societies::where('login_tokens', $token)->first();
        if ($society == null || $token == null) {
            return response([
                'message' => 'Unauthorized user'
            ], 401);
        }

        $consultation = Consultations::where('society_id', $society->id)->first();

        $doctor_name = null;
        if ($consultation->doctor_id != null) {
            $doctor_name = Medicals::find($consultation->doctor_id)->first()->name;
        }

        return response([
            'consultations' => [
                'id' => $consultation->id,
                'status' => $consultation->status,
                'disease_history' => $consultation->disease_history,
                'current_symptoms' => $consultation->current_symptoms,
                'doctor_notes' => $consultation->doctor_note,
                'doctor' => $doctor_name
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = $request->query('token');
        $society = Societies::where('login_tokens', $token)->first();
        if (Societies::where('login_tokens', $token)->first() == null) {
            return response([
                'message' => 'Unauthorized user'
            ], 401);
        }

        $diseaseHistory = $request->input('disease_history');
        $currentSymptoms = $request->input('current_symptoms');

        $consultation = new Consultations();
        $consultation->fill([
            'society_id' => $society->id,
            'status' => 'pending',
            'disease_history' => $diseaseHistory,
            'current_symptoms' => $currentSymptoms
        ]);
        $consultation->save();
        return response([
            'message' => 'Request consultation sent successful'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

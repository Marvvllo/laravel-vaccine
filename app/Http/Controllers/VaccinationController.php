<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Vaccines;
use App\Models\Societies;
use App\Models\Vaccinations;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($society == null || $token == null) {
            return response([
                'message' => 'Unauthorized user'
            ], 401);
        }

        $vaccinationsCount = Vaccinations::where('society_id', $society->id)->count();

        // Check how many vaccinations have been done by society
        switch ($vaccinationsCount) {
            case 0:
                return response([
                    'message' => 'First vaccination registered successful'
                ]);

            case 1:
                $response = [
                    'message' => 'Second vaccination registered successful'
                ];

                $vaccination = Vaccinations::where('society_id', $society->id)->first();

                if (strtotime($vaccination->date) > strtotime('-30 days')) {
                    return response([
                        'message' => 'Wait at least +30 days from 1st Vaccination',
                    ], 401);
                }
                return response($response, 200);

            case 2:
                $response = [
                    'message' => 'Society has been 2x vaccinated'
                ];
                return response($response, 401);
        }
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
     * @param  \Illum
     * 
     * inate\Http\Request  $request
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

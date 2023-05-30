<?php

namespace App\Http\Controllers;

use App\Models\Societies;
use App\Models\Spot_vaccines;
use App\Models\Spots;
use App\Models\Vaccinations;
use App\Models\Vaccines;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SpotController extends Controller
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

        $spots = Spots::where('regional_id', $society->regional_id)->get();
        $response = array();
        foreach ($spots as $spot) {
            $spot_vaccines = Spot_vaccines::where('spot_id', $spot->id)->get('vaccine_id');
            $vaccines = Vaccines::find($spot_vaccines)->pluck('name');
            $response[] = [
                'id' => $spot->id,
                'name' => $spot->name,
                'address' => $spot->address,
                'serve' => $spot->serve,
                'capacity' => $spot->capacity,
                'available_vaccines' => $vaccines
            ];
        }
        return response([
            'spots' => $response
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($spotID, Request $request)
    {
        $token = $request->query('token');
        $date = $request->exists('date') && strtotime($request->query('date')) ? date('F d, Y', strtotime($request->query('date'))) : 'now';
        $society = Societies::where('login_tokens', $token)->first();
        if ($society == null || $token == null) {
            return response([
                'message' => 'Unauthorized user'
            ], 401);
        }

        $spot = Spots::find($spotID);
        $vaccinationsCount = Vaccinations::where('spot_id', $spotID)->count();

        return response([
            'date' => $date,
            'spot' => [
                'id' => $spot->id,
                'name' => $spot->name,
                'address' => $spot->address,
                'serve' => $spot->serve,
                'capacity' => $spot->capacity,
            ],
            'vaccinations_count' => $vaccinationsCount
        ]);
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

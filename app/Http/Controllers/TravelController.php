<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Http\Requests\SearchSeatRuleRequest;
use App\Http\Requests\TravelRulesRequest;
use App\Http\Services\ApiService;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * Display a listing of the cities.
     *
     * @param \App\Http\Services\ApiService $apiService
     * @return \Illuminate\Http\Response
     */
    public function index(ApiService $apiService)
    {
        try {
            $cities = $apiService->allCities();
            return Response::json($cities, __('Cities successfully listed'), 200);
        } catch (\Exception $e) {
            return Response::exception($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param \App\Http\Services\ApiService $apiService
     * @param \App\Http\Requests\TravelRulesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function searchTravel(TravelRulesRequest $request, ApiService $apiService)
    {
        try {
            $listPassages = $apiService->fetchTravel($request->all());
            return Response::json($listPassages, __('Passages successfully listed'), 200);
        } catch (\Exception $e) {
            if ($e->getCode() == 422) {
                return Response::exception($e, __('Tickets available only for cities in SP and PR'), $e->getCode());
            }
            return Response::exception($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchSeats(SearchSeatRuleRequest $request, ApiService $apiService)
    {
        try {
            $seats = $apiService->fetchSeats($request->travelId);
            return Response::json($seats, __('Seats successfully listed'), 200);
        } catch (\Exception $e) {
            return Response::exception($e);
        }
    }
}

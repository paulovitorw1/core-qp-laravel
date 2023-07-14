<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiService
{
    /**
     * The base URL of the API.
     *
     * @var string
     */
    private string $baseUrl;

    /**
     * The authorization header value for API requests.
     *
     * @var string
     */
    private string $authorization;

    /**
     * Create a new instance of the ApiService.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUrl = config('api.base_url');
        $this->authorization = config('api.authorization');
    }

    /**
     * Retrieve a list of all cities.
     *
     * @return array
     */
    public function allCities(): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authorization,
        ])->get($this->baseUrl . '/stops');

        return $response->json();
    }

    /**
     * Fetch travel information based on the given request.
     *
     * @param array $request
     * @return array
     * @throws \Exception
     */
    public function fetchTravel(array $request): array
    {
        $nameDepartureCity = Str::contains(Str::upper($request['nameDepartureCity']), ['SP', 'PR']);
        $nameArrivalCity = Str::contains(Str::upper($request['nameArrivalCity']), ['SP', 'PR']);
        if (!$nameDepartureCity || !$nameArrivalCity) {
            throw new \Exception('Tickets available only for cities in SP and PR', 422);
        }

        $response = Http::withHeaders([
            'Authorization' => $this->authorization,
        ])->post($this->baseUrl . '/new/search', [
            'from' => $request['from'],
            'to' => $request['to'],
            'travelDate' => $request['travelDate'],
            'affiliateCode' => 'DDE',
        ]);

        $responsePassage = $this->buildTravelInformation($response->json());
        $responsePassage = $responsePassage->values();
        return $responsePassage->toArray();
    }

    /**
     * Fetch available seats for a specific travel.
     *
     * @param string $travelId
     * @return array
     */
    public function fetchSeats(string $travelId): array
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authorization,
        ])->post($this->baseUrl . '/new/seats', [
            'travelId' => $travelId,
        ]);

        return $response->json();
    }

    /**
     * Build travel information by sorting the list of travels.
     *
     * @param array $listTravel
     * @return \Illuminate\Support\Collection
     */
    private function buildTravelInformation(array $listTravel)
    {
        $listTravelCollection = collect($listTravel);

        $sortedCollection = $listTravelCollection->sortBy(function ($travel) {
            return Carbon::parse($travel['departure']['date'] . $travel['departure']['time']);
        });
        // OR
        // $sortedCollection = $listTravelCollection->sortBy('departure.date')->sortBy('departure.time');
        return $sortedCollection;
    }
}

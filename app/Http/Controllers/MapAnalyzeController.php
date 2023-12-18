<?php

namespace App\Http\Controllers;

use App\Models\PopulationDensity;
use App\Models\Store;

class MapAnalyzeController extends Controller
{
    public function stores()
    {
        $stores = Store::with('location')->get();
        $storesWithLocation = $stores->map(function ($store) use ($stores) {
            return [
                "id" => $store->id,
                "x" => $store->location->coordinates->getLng(),
                "y" => $store->location->coordinates->getLat(),
                "name" => $store->name,
                "details" => $store->location->detail,
            ];
        });

        return $storesWithLocation;
    }
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }
    public function showStore(Store $store)
    {
        $multiPoints = PopulationDensity::distanceValue('coordinates', $store->location->coordinates)
            ->distance('coordinates', $store->location->coordinates, 0.05) //Radius: ~5.95km
            ->orderByDistance('coordinates', $store->location->coordinates, 'desc')
            ->get();
        $geojs = [
            "type" => "FeatureCollection",
            "features" => $multiPoints->map(function ($point) use ($store) {

                return [
                    "type" => "Feature",
                    "geometry" => [
                        "type" => "Point",
                        "coordinates" => [$point->coordinates->getLat(), $point->coordinates->getLng()],
                    ],
                    "properties" => [
                        'hvDistance' => $this->haversineGreatCircleDistance($point->coordinates->getLat(), $point->coordinates->getLng(), $store->location->coordinates->getLat(), $store->location->coordinates->getLng(), 6371000),
                        'distance' => $point->distance
                    ],
                ];
            })

        ];

        return response()->json($geojs);
    }


}
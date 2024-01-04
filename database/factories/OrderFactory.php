<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $store = Store::with('location')->inRandomOrder()->first();
        $contact = 0;
        $isContinue = true;

        do {
            $contact = Contact::inRandomOrder()->first()->load('location');

            $distance = $this->haversineGreatCircleDistance(
                $store->location->coordinates->getLat(),
                $store->location->coordinates->getLng(),
                $contact->location->coordinates->getLat(),
                $contact->location->coordinates->getLng()
            );

            if ($distance <= 5000) {
                $isContinue = false;
            }
        } while ($isContinue);

        return [
            'contact_id' => $contact->id
        ];
    }
    private function nrand($mean, $sd)
    {
        $x = mt_rand() / mt_getrandmax();
        $y = mt_rand() / mt_getrandmax();
        return round(sqrt(-2 * log($x)) * cos(2 * pi() * $y) * $sd + $mean);
    }

    private function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
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
}

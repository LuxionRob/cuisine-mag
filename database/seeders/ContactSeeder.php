<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Store;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $store = Store::inRandomOrder()->first();

        foreach ($users as $user) {
            $return = $this->generateRandomPoint([$store->location->coordinates->getLat(), $store->location->coordinates->getLng()], 5000);
            $coordinate = ['lat' => $return[0], 'lng' => $return[1]];
            $contact = Contact::factory()->for($user, 'user')->hasLocation(1, ['coordinates' => new Point($coordinate['lat'], $coordinate['lng'])])->count(2)->create();
        }
    }

    private function generateRandomPoint($centre, $radius)
    {
        $radius_earth = 6371000; //metres

        //Pick random distance within $distance;
        $distance = lcg_value() * $radius;

        //Convert degrees to radians.
        $centre_rads = array_map('deg2rad', $centre);

        //First suppose our point is the north pole.
        //Find a random point $distance miles away
        $lat_rads = (pi() / 2) - $distance / $radius_earth;
        $lng_rads = lcg_value() * 2 * pi();


        //($lat_rads,$lng_rads) is a point on the circle which is
        //$distance miles from the north pole. Convert to Cartesian
        $x1 = cos($lat_rads) * sin($lng_rads);
        $y1 = cos($lat_rads) * cos($lng_rads);
        $z1 = sin($lat_rads);


        //Rotate that sphere so that the north pole is now at $centre.

        //Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
        $rot = (pi() / 2) - $centre_rads[0];
        $x2 = $x1;
        $y2 = $y1 * cos($rot) + $z1 * sin($rot);
        $z2 = -$y1 * sin($rot) + $z1 * cos($rot);

        //Rotate in z axis by $rot = $centre_rads[1]
        $rot = $centre_rads[1];
        $x3 = $x2 * cos($rot) + $y2 * sin($rot);
        $y3 = -$x2 * sin($rot) + $y2 * cos($rot);
        $z3 = $z2;


        //Finally convert this point to polar co-ords
        $lng_rads = atan2($x3, $y3);
        $lat_rads = asin($z3);

        return array_map('rad2deg', array($lat_rads, $lng_rads));
    }
}

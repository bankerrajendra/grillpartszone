<?php

namespace App\Http\Controllers;

use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function fetchLocation(Request $request, LocationRepository $locationRepository)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $output = array();
        try {
            if ( ($select == 'country' || $select == 'country_shipping' || $select == 'shipping_country_id') && ($dependent == 'city' || $dependent == 'city_shipping' || $dependent == 'shipping_city_id') ) {
                $locations = $locationRepository->getCountryCities($value);
                $count = 0;
                foreach ($locations as $location) {
                    $output[$count]['id'] = $location->id;
                    $output[$count]['value'] = $location->name;
                    $count++;
                }
                return response()->json($output);
            } elseif ( ($select == 'country' || $select == 'country_shipping' || $select == 'shipping_country_id') && ($dependent == 'state' || $dependent == 'state_shipping' || $dependent == 'shipping_state_id') ) {
                $locations = $locationRepository->getStates($value);
                $count = 0;
                foreach ($locations as $location) {
                    $output[$count]['id'] = $location->id;
                    $output[$count]['value'] = $location->name;
                    $count++;
                }
                return response()->json($output);
            } elseif ( ($select == 'state' || $select == 'state_shipping' || $select == 'shipping_state_id') && ($dependent == 'city' || $dependent == 'city_shipping' || $dependent == 'shipping_city_id') ) {
                $locations = $locationRepository->getCities($value);
                $count = 0;
                foreach ($locations as $location) {
                    $output[$count]['id'] = $location->id;
                    $output[$count]['value'] = $location->name;
                    $count++;
                }
                return response()->json($output);
            }
        } catch (Exception $e) {
            return [];
        }
        return false;
    }
}
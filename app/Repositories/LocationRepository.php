<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\City;
use App\Models\State;

class LocationRepository
{

    public function getLimitedCountries(array $ids)
    {
        return Country::whereIn('id', $ids)->orderBy("sort", 'desc')->orderBy("name")->get();
    }

    public function getCountries()
    {
        return Country::orderBy("sort", 'desc')->orderBy("name")->get();
    }

    public function getCountryById($country_id)
    {

        $data = json_decode(Country::where('id', $country_id)->first());
        return $data->name;
    }

    public function getStates($country_id)
    {
        if (is_array($country_id)) {
            return State::whereIn('country_id', $country_id)->get();
        } else {
            return State::where('country_id', $country_id)->get();
        }
    }

    public function getStateBy($id)
    {
        return State::find($id);
    }

    public function getCities($state_id)
    {
        if (is_array($state_id)) {
            return City::whereIn('state_id', $state_id)->get();
        } else {
            return City::where('state_id', $state_id)->get();
        }
    }

    public function getCountryCities($state_id)
    {
        if (is_array($state_id)) {

            return City::whereIn('state_id', function ($query) use ($state_id) {
                $query->select('id')->whereIn('country_id', $state_id)->from('states');
            })->orderBy('name')->get();
        } else {
            return City::where('state_id', $state_id)->get();
        }
    }

    public function getCitiesOfCountries($countries)
    {
        if (is_array($countries)) {
            return City::whereIn('state_id', function ($query) use ($countries) {
                $query->select('id')->whereIn('country_id', $countries)->from('states');
            })->orderBy('name')->get();
        } else {
            return City::where('state_id', function ($query) use ($countries) {
                $query->select('id')->where('country_id', $countries)->from('states');
            })->orderBy('name')->get();
        }
    }
}
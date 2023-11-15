<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\SubDistrict;

class DistrictController extends Controller
{
    public function getProvinces()
    {
        $result = Province::orderBy('name', 'ASC')->get();

        return $result;
    }

    public function getCities($provinceId = null)
    {
        $result = City::where('provinceId', $provinceId)->orderBy('name', 'ASC')->get();

        return $result;
    }

    public function getDistricts($cityId = null)
    {
        $result = District::where('cityId', $cityId)->orderBy('name', 'ASC')->get();

        return $result;
    }

    public function getSubDistricts($districtId = null)
    {
        $result = SubDistrict::where('districtId', $districtId)->orderBy('name', 'ASC')->get();

        return $result;
    }

    public function getAjaxProvinces()
    {
        $result = Province::orderBy('name', 'ASC')->get();

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function getAjaxCities($provinceId = null)
    {
        $result = City::where('provinceId', $provinceId)->orderBy('name', 'ASC')->get();

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function getAjaxDistricts($cityId = null)
    {
        $result = District::where('cityId', $cityId)->orderBy('name', 'ASC')->get();

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }

    public function getAjaxSubDistricts($districtId = null)
    {
        $result = SubDistrict::where('districtId', $districtId)->orderBy('name', 'ASC')->get();

        return response()->json(['metaData' => ['code' => 200, 'message' => ''], 'response' => $result], 200);
    }
}

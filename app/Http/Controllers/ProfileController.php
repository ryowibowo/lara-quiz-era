<?php

namespace App\Http\Controllers;

use App\Helpers\eKreative;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DistrictController;

class ProfileController extends Controller
{
    public function index()
    {
        $data = User::join('user_detail', 'users.id', '=', 'user_detail.userId')
            ->where('users.id', eKreative::myId())
            ->first();

        $userLocation = UserDetail::join('m_sub_districts', 'user_detail.subDistrictId', '=', 'm_sub_districts.id')
            ->join('m_districts', 'm_sub_districts.districtId', '=', 'm_districts.id')
            ->join('m_cities', 'm_districts.cityId', '=', 'm_cities.id')
            ->join('m_provinces', 'm_cities.provinceId', '=', 'm_provinces.id')
            ->where('user_detail.userId', eKreative::myId())
            ->select(
                'm_sub_districts.id AS subDistrictId',
                'm_sub_districts.name AS subDistrictName',
                'm_sub_districts.zipCode AS zipCode',
                'm_districts.id AS districtId',
                'm_districts.name AS districtName',
                'm_cities.id AS cityId',
                'm_cities.name AS cityName',
                'm_provinces.id AS provinceId',
                'm_provinces.name AS provinceName'
            )
            ->first();

        $mDistrict = new DistrictController();

        $provinces = $mDistrict->getProvinces();
        $cities = $mDistrict->getCities($userLocation->provinceId);
        $districts = $mDistrict->getDistricts($userLocation->cityId);
        $subDistricts = $mDistrict->getSubDistricts($userLocation->districtId);
        return view('pages.profile.index', compact('data', 'userLocation', 'provinces', 'cities', 'districts', 'subDistricts'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        if ($user->email != $request->email) {
            $check = User::where("email", $request->email)->first();

            if ($check) {
                return response()->json(['metaData' => ['code' => 'EMAIL_USED', 'message' => 'Email already used.'], 'response' => ''], 200);
            }
        }

        if ($user->phone_number != $request->phone_number) {
            $check = User::where("phone_number", $request->phone_number)->first();

            if ($check) {
                return response()->json(['metaData' => ['code' => 'PHONE_USED', 'message' => 'Phone number already used.'], 'response' => ''], 200);
            }
        }

        DB::beginTransaction();
        try {
            $result = UserDetail::where('userId', $id)->first();
            $result->firstName = $request->firstName;
            $result->lastName = $request->lastName;
            $result->gender = $request->gender;
            $result->dob = date("Y-m-d", strtotime($request->dob));
            $result->address = $request->address;
            $result->subDistrictId = $request->subDistrict;
            $result->updated_by = eKreative::myId();
            $result->save();

            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data berhasil diupdate.'], 'response' => $result], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }
}

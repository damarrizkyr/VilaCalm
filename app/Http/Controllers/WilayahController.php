<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class WilayahController extends Controller
{
    //
    private const CACHE_TTL = 86400; // 24 hours in seconds

    /**
     * Get all provinces
     * Returns code as 'id' for frontend compatibility
     */
    public function provinces()
    {
        return Cache::remember('wilayah_provinces', self::CACHE_TTL, function () {
            // Ambil semua provinsi, urutkan nama
            return Province::orderBy('name')
                ->get()
                ->map(function ($prov) {
                    return [
                        'id' => $prov->code, // Frontend butuh 'id'
                        'name' => ucwords(strtolower($prov->name)), // Rapikan nama (Title Case)
                    ];
                });
        });
    }

    public function regencies($provinceCode)
    {
        return Cache::remember("wilayah_regencies_{$provinceCode}", self::CACHE_TTL, function () use ($provinceCode) {
            return City::where('province_code', $provinceCode)
                ->orderBy('name')
                ->get()
                ->map(function ($city) {
                    return [
                        'id' => $city->code,
                        'name' => ucwords(strtolower($city->name)),
                    ];
                });
        });
    }

    /**
     * Get districts by regency/city code
     */
    public function districts($cityCode)
    {
        return Cache::remember("wilayah_districts_{$cityCode}", self::CACHE_TTL, function () use ($cityCode) {
            return District::where('city_code', $cityCode)
                ->orderBy('name')
                ->get(['code', 'name'])
                ->map(function ($district) {
                    return [
                        'id' => $district->code,
                        'name' => $district->name,
                    ];
                });
        });
    }

    /**
     * Get villages by district code
     */
    public function villages($districtCode)
    {
        return Cache::remember("wilayah_villages_{$districtCode}", self::CACHE_TTL, function () use ($districtCode) {
            return Village::where('district_code', $districtCode)
                ->orderBy('name')
                ->get(['code', 'name'])
                ->map(function ($village) {
                    return [
                        'id' => $village->code,
                        'name' => $village->name,
                    ];
                });
        });
    }
}

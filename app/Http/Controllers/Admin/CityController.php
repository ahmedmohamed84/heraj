<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('region')->paginate(10);
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regions = Region::all();
        return view('admin.cities.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        City::create($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'تم إنشاء المدينة بنجاح.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        $regions = Region::all();
        return view('admin.cities.edit', compact('city', 'regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $city->update($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'تم تحديث المدينة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'تم حذف المدينة بنجاح.');
    }
}

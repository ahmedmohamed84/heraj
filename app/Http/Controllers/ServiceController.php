<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()->paginate(20);
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // We need to pass all categories to the view for the dropdown
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            // Add other service fields validation here (description, price, etc.)
            'attributes' => 'nullable|array'
        ]);

        // Create the main service record
        $service = Service::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'category_id' => $validatedData['category_id'],
            // Add other fields here
        ]);

        // Prepare the attributes for sync
        if (!empty($validatedData['attributes'])) {
            $attributesToSync = [];
            foreach ($validatedData['attributes'] as $attributeId => $value) {
                // Ensure value is not null before syncing
                if ($value !== null) {
                    $attributesToSync[$attributeId] = ['value' => $value];
                }
            }
            // Sync the attributes with their values
            $service->attributes()->sync($attributesToSync);
        }

        // Redirect to the service page or a success page
        return redirect()->route('services.show', $service)->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        // Placeholder for viewing a single service
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        // Eager load the relationships needed
        $service->load('attributes');
        $categories = Category::all();

        // Create a simple map of [attribute_id => value] for easy lookup in the view
        $serviceAttributes = $service->attributes->pluck('pivot.value', 'id');

        return view('services.edit', compact('service', 'categories', 'serviceAttributes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'attributes' => 'nullable|array'
        ]);

        // Update the main service record
        $service->update($validatedData);

        // Prepare and sync attributes
        $attributesToSync = [];
        if (!empty($validatedData['attributes'])) {
            foreach ($validatedData['attributes'] as $attributeId => $value) {
                if ($value !== null) {
                    $attributesToSync[$attributeId] = ['value' => $value];
                }
            }
        }
        $service->attributes()->sync($attributesToSync);

        return redirect()->route('services.show', $service)->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        // Optional: Add authorization check here to ensure the user can delete this service
        // For example: $this->authorize('delete', $service);

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}

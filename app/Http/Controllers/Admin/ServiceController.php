<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceAttributeValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with(['category', 'user', 'city'])->latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        $cities = City::all();
        return view('admin.services.create', compact('categories', 'users', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'phone' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:pending,approved,rejected',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'attributes' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::create($validated);

        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeId => $value) {
                if($value){
                    ServiceAttributeValue::create([
                        'service_id' => $service->id,
                        'attribute_id' => $attributeId,
                        'value' => $value,
                    ]);
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('services/gallery', 'public');
                $service->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $categories = Category::all();
        $users = User::all();
        $cities = City::all();

        // Eager load relationships for efficiency
        $service->load('attributeValues', 'category.attributes');

        // Create a key-value map of existing attribute_id => value
        $serviceAttributeValues = $service->attributeValues->pluck('value', 'attribute_id');

        return view('admin.services.edit', compact(
            'service',
            'categories',
            'users',
            'cities',
            'serviceAttributeValues'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'phone' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'required|in:pending,approved,rejected',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'attributes' => 'nullable|array',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);

        // Sync attributes
        $service->attributeValues()->delete();
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attributeId => $value) {
                if ($value) {
                    ServiceAttributeValue::create([
                        'service_id' => $service->id,
                        'attribute_id' => $attributeId,
                        'value' => $value,
                    ]);
                }
            }
        }

        if ($request->hasFile('images')) {
            // Delete old gallery images
            foreach ($service->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('services/gallery', 'public');
                $service->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        foreach ($service->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    /**
     * Delete an image from the service gallery.
     */
    public function deleteImage($imageId)
    {
        $image = \App\Models\ServiceImage::findOrFail($imageId);
        
        // Delete the file from storage
        Storage::disk('public')->delete($image->path);
        
        // Delete the record from database
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
}

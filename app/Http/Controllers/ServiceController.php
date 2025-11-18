<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::where('is_active', true)
            ->latest()
            ->with('category', 'city')
            ->paginate(15);

        return view('services.index', compact('services'));
    }

    /**
     * Display a listing of the user's own services.
     */
    public function myServices()
    {
        $services = Service::where('user_id', auth()->id())
            ->latest()
            ->with('category', 'city')
            ->paginate(15);

        return view('services.my-services', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $cities = City::all();
        return view('services.create', compact('categories', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'phone' => 'required|string|max:20',
            'description' => 'required|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'attributes' => 'nullable|array',
        ]);

        // Handle main image upload
        $mainImagePath = $request->file('main_image')->store('services/main', 'public');

        $service = Service::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'price' => $validated['price'],
            'city_id' => $validated['city_id'],
            'category_id' => $validated['category_id'],
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'image' => $mainImagePath,
            'is_active' => false,
        ]);

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $galleryImage) {
                $path = $galleryImage->store('services/gallery', 'public');
                $service->gallery()->create(['path' => $path]);
            }
        }

        // Save dynamic attributes
        if (!empty($validated['attributes'])) {
            $attributesToSync = [];
            foreach ($validated['attributes'] as $attributeId => $data) {
                if (isset($data['value']) && $data['value'] !== null) {
                    $attributesToSync[$attributeId] = ['value' => $data['value']];
                }
            }
            $service->attributes()->sync($attributesToSync);
        }

        return redirect()->route('services.my')->with('success', __('Service created successfully. It is pending admin approval.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        // Eager load all necessary relationships for the main service
        $service->load(['user', 'category', 'city', 'gallery', 'attributes']);

        // Fetch related services from the same category
        $relatedServices = Service::where('category_id', $service->category_id)
            ->where('id', '!=', $service->id) // Exclude the current service
            ->where('is_active', true) // Only show active services
            ->with(['city', 'category']) // Eager load for performance
            ->latest()
            ->limit(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        // Authorization: Ensure the user owns this service
        if (auth()->id() !== $service->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $service->load('attributes', 'gallery');
        $categories = Category::whereNull('parent_id')->get();
        $cities = City::all();

        // Create a simple key-value array of saved attributes for JS
        $savedAttributes = $service->attributes->pluck('pivot.value', 'id')->toArray();

        return view('services.edit', compact('service', 'categories', 'cities', 'savedAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // Authorization: Ensure the user owns this service
        if (auth()->id() !== $service->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'phone' => 'required|string|max:20',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Nullable on update
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'attributes' => 'nullable|array',
        ]);

        // Handle main image update
        if ($request->hasFile('image')) {
            // Delete old image
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            // Store new image
            $validated['image'] = $request->file('image')->store('services/main', 'public');
        }

        // Handle gallery images update
        if ($request->hasFile('gallery_images')) {
            // Note: This adds new images. For a full replacement, you'd delete old ones first.
            // To keep it simple, we'll just add new ones. A more complex UI could manage individual deletions.
            foreach ($request->file('gallery_images') as $galleryImage) {
                $path = $galleryImage->store('services/gallery', 'public');
                $service->gallery()->create(['path' => $path]);
            }
        }

        $service->update($validated);

        // Sync attributes
        $attributesToSync = [];
        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attributeId => $data) {
                 if (isset($data['value']) && $data['value'] !== null) {
                    $attributesToSync[$attributeId] = ['value' => $data['value']];
                }
            }
        }
        $service->attributes()->sync($attributesToSync);


        return redirect()->route('services.my')->with('success', __('Service updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Authorization: Ensure the user owns this service
        if (auth()->id() !== $service->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete main image from storage
        if ($service->main_image) {
            Storage::disk('public')->delete($service->main_image);
        }

        // Delete gallery images from storage
        foreach ($service->gallery as $image) {
            Storage::disk('public')->delete($image->path);
            // The model event on ServiceImage should handle deleting the DB record.
        }

        // The service's deleting event (if set up) or a DB cascade should handle related records.
        $service->delete();

        return redirect()->route('services.my')->with('success', __('Service deleted successfully.'));
    }
}
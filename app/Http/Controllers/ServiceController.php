<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeOfService;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = TypeOfService::get();
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            $service = TypeOfService::create([
                'service_name' => $request->service_name,
                'price' => $request->price,
                'description' => $request->description,
            ]);
        } catch (\Throwable $th) {
            return redirect()->back();
        }

        return redirect()->route('service.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = TypeOfService::findOrFail($id);
        return view('service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:50',
            'price' => 'required|numeric',
            'description' => 'nullable|string|max:255',
        ]);

        $service = TypeOfService::findOrFail($id);
        $service->update($request->all());

        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = TypeOfService::findOrFail($id);
        $service->delete();

        return redirect()->route('service.index');
    }
}

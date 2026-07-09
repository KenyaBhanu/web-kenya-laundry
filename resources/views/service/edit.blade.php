@extends('layouts.app')
@section('title', 'Edit Service')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('service.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Service Name
                        </label><br>
                        <input type="text" name="service_name" value="{{ $service->service_name }}" placeholder="Enter service name" class="input w-7/8" required/>
                    </div>
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Price
                        </label><br>
                        <input type="text" name="price" value="{{ $service->price }}" placeholder="Enter price" class="input w-7/8" required/>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Description
                        </label><br>
                        <input type="text" name="description" value="{{ $service->description }}" placeholder="Enter description" class="input w-7/8" />
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

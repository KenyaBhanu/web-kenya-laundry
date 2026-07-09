@extends('layouts.app')
@section('title', 'Create Service')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('service.store') }}" method="POST">
                @csrf
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Service Name
                        </label><br>
                        <input type="text" name="service_name" placeholder="Enter service name" class="input w-7/8" required/>
                    </div>
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Price
                        </label><br>
                        <input type="text" name="price" placeholder="Enter price" class="input w-7/8" required>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Description
                        </label><br>
                        <input type="text" name="description" placeholder="Enter description" class="input w-7/8" />
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Create Service</button>
                </div>
            </form>
        </div>
    </div>
@endsection

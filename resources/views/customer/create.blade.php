@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Name
                        </label><br>
                        <input type="text" name="customer_name" placeholder="Enter name" class="input w-7/8" required/>
                    </div>
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Phone Number
                        </label><br>
                        <input type="text" name="phone" placeholder="Enter phone number" class="input w-7/8" required/>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Address
                        </label><br>
                        <input type="text" name="address" placeholder="Enter address" class="input w-7/8" required/>
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Create Customer</button>
                </div>
            </form>
        </div>
    </div>
@endsection

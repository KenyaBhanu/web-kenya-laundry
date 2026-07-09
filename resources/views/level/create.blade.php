@extends('layouts.app')
@section('title', 'Create Level')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('level.store') }}" method="POST">
                @csrf
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Level Name
                        </label><br>
                        <input type="text" placeholder="Enter level name" name="name" class="input w-7/8" required/>
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Create Level</button>
                </div>
            </form>
        </div>
    </div>
@endsection

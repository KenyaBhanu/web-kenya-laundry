@extends('layouts.app')
@section('title', 'Edit Level')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('level.store', $level->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Level Name
                        </label><br>
                        <input type="text" placeholder="Enter service name" class="input w-7/8" value="{{ $level->level_name }}" required/>
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Create User')
@section('content')
    <div class="card bg-base-100 w-full shadow-sm">
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Name
                        </label><br>
                        <input type="text" name="name" placeholder="Enter name" class="input w-7/8" required/>
                    </div>
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Email
                        </label><br>
                        <input type="email" name="email" placeholder="Enter email" class="input w-7/8" required/>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Password
                        </label><br>
                        <input type="password" name="password" placeholder="Enter Password" class="input w-7/8" required/>
                    </div>
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Confirm Password
                        </label><br>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                            class="input w-7/8" required/>
                    </div>
                </div>
                <div class="flex">
                    <div class="mb-2 w-1/2">
                        <label class="label font-medium text-base">
                            Role
                        </label><br>
                        <select name="id_level" class="select w-7/8">
                            <option disabled selected>Pick one</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->level_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-actions mt-4">
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
@endsection

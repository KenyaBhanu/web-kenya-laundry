<!DOCTYPE html>
<html lang="en" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col items-center justify-center-safe font-ubuntu">
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="text-center lg:text-left">
                <h1 class="text-5xl font-bold">Laundry Management System</h1>
                <h1 class="text-4xl font-bold">Log In</h1>
            </div>
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <div class="card-body">
                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <fieldset class="fieldset">
                            <label class="label" for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="input @error('email') input-error @enderror" placeholder="Email" required
                                autofocus />
                            @error('email')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <label class="label" for="password">Password</label>
                            <input type="password" id="password" name="password"
                                class="input @error('password') input-error @enderror" placeholder="Password"
                                required />
                            @error('password')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror

                            {{-- <div><a class="link link-hover">Forgot password?</a></div> --}}
                            <button type="submit" class="btn btn-primary mt-4">Login</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
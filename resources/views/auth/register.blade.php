<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body>
     <div
        class="min-h-screen bg-slate-100 px-4 py-10 flex items-center justify-center"
    >
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl">
            <!-- Heading -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-slate-900">
                    Create an account
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Fill in your details to get started.
                </p>
            </div>

            <!-- Register Form -->
            <form action="/register" method="POST" class="space-y-5">
               @csrf
                <!-- Name -->
                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Name
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{old('name')}}"
                        placeholder="Enter your full name"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                    @error('name')
                    <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{old('email')}}"
                        placeholder="you@example.com"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                    @error('email')
                    <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Password
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        value="{{old('password')}}"
                        placeholder="At least 8 characters"
                        minlength="8"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                    @error('password')
                    <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Confirm Password
                    </label>

                    <input
                        id="confirmPassword"
                        name="password_confirmation"
                        type="password"
                        value="{{old('password_confirmation')}}"
                        placeholder="Re-enter your password"
                        minlength="8"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                    @error('confirmPassword')
                    <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-200"
                >
                    Register
                </button>
            </form>

            <!-- Sign In Link -->
            <p class="mt-6 text-center text-sm text-slate-500 flex justify-center gap-2">
                Already have an account?
                <a
                    href="/login"
                    class="font-semibold text-blue-600 hover:text-blue-800"
                >
                    Log in
                </a>
                
            </p>
        </div>
    </div>
</body>
</html>
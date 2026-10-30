<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <h1 class="text-3xl font-bold text-slate-900">Login</h1>

                <p class="mt-2 text-sm text-slate-500">
                    Welcome back. Enter your credentials to continue.
                </p>
            </div>

            <!-- login Form -->
            <form action="/login" method="POST" class="space-y-5">
                @csrf

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
                        placeholder="At least 8 characters"
                        minlength="8"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    />
                    @error('password')
                    <div class="text-red-600">{{$message}}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700 focus:ring-4 focus:ring-blue-200"
                >
                    Login
                </button>
            </form>

            <!-- Sign In Link -->
            <p class="mt-6 text-center text-sm text-slate-500">
                Don't have an account?
                <a
                    href="/"
                    class="font-semibold text-blue-600 hover:text-blue-800"
                >
                    Register
                </a>
            </p>
        </div>
    </div>
</body>
</html>
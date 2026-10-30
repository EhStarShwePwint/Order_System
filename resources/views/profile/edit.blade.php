@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-y-auto p-8 text-slate-800">
    
    <!-- 1. Breadcrumbs -->
    <nav class="flex text-sm text-slate-500 mb-4">
        <a href="" class="hover:text-blue-600 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">Profile</span>
    </nav>

    <!-- 2. Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Profile</h1>
        <p class="text-slate-500 mt-2">Manage your account information and password.</p>
    </div>

    <div class="max-w-2xl space-y-8">
        <div class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">Profile information</h2>
            <p class="text-sm text-slate-500 mt-1 mb-6">Update your name and email address.</p>

            <!-- Success Message for Profile Update -->
            @if (session('status') === 'profile-updated')
                <div class="mb-4 text-sm font-medium text-green-600">Saved successfully.</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <!-- Name Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-900 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-900 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-md text-sm font-medium transition shadow-sm">
                    Update
                </button>
            </form>
        </div>
                
        <div class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
            <h2 class="text-lg font-bold text-slate-900">Update password</h2>
            <p class="text-sm text-slate-500 mt-1 mb-6">Ensure your account is using a strong password.</p>

            <!-- Success Message for Password Update -->
            @if (session('status') === 'password-updated')
                <div class="mb-4 text-sm font-medium text-green-600">Password updated successfully.</div>
            @endif

            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-900 mb-2">Current password</label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                    @error('current_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- New Password -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-900 mb-2">New password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-900 mb-2">Confirm password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-md text-sm font-medium transition shadow-sm">
                    Update password
                </button>
            </form>
        </div>

    </div>
</main>
@endsection
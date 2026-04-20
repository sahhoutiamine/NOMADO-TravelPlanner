@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 md:py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto w-full">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Your Profile</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your account settings and preferences.</p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-5 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium text-sm">Profile updated successfully.</span>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-5 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium text-sm">Password updated successfully.</span>
            </div>
        @endif

        <div class="space-y-8">
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Profile Information</h2>
                    <p class="text-sm text-gray-500 mt-1">Update your account's profile information and email address.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="pt-2 flex items-center gap-4">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl font-semibold text-sm hover:bg-primary-600 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Update Password</h2>
                    <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div>
                        <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1.5">Current Password</label>
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1.5">New Password</label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="pt-2 flex items-center gap-4">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl font-semibold text-sm hover:bg-primary-600 transition-colors">
                            Save Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-red-600">Delete Account</h2>
                    <p class="text-sm text-gray-500 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                </div>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-6 py-2.5 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 focus:outline-none transition-colors"
                >
                    Delete Account
                </x-danger-button>
            </div>
        </div>
    </div>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
        @csrf
        @method('delete')

        <h2 class="text-xl font-bold text-gray-900 mb-2">Are you sure you want to delete your account?</h2>
        <p class="text-sm text-gray-500 mb-6">
            Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
        </p>

        <div class="mb-6">
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" placeholder="Password"
                   class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-colors">
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-4">
            <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">
                Cancel
            </button>
            <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-xl font-semibold text-sm hover:bg-red-700 transition-colors">
                Delete Account
            </button>
        </div>
    </form>
</x-modal>
@endsection

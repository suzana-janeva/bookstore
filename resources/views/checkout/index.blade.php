@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold tracking-tight text-ink">Checkout</h1>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
        {{-- Shipping form --}}
        <form method="POST" action="{{ route('checkout.store') }}" class="card space-y-5 p-6 lg:col-span-2">
            @csrf
            <h2 class="text-lg font-bold text-ink">Shipping details</h2>

            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink">Full name</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-input-brand" required>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold text-ink">Address</label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-input-brand" placeholder="Street address" required>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="sm:col-span-1">
                    <label class="mb-1.5 block text-sm font-semibold text-ink">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="form-input-brand" required>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink">Postal code</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="form-input-brand" required>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-semibold text-ink">Country</label>
                    <input type="text" name="country" value="{{ old('country') }}" class="form-input-brand" required>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2 8.5h20M6 16h4m-7-.5v.5a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-9a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v9Z"/></svg>
                Pay with Stripe
            </button>
            <p class="text-center text-xs text-gray-400">You'll be redirected to Stripe's secure checkout to complete payment.</p>
        </form>

        {{-- Order summary --}}
        <div class="lg:col-span-1">
            <div class="card space-y-4 p-6">
                <h2 class="text-lg font-bold text-ink">Your order</h2>
                <div class="space-y-3">
                    @foreach($items as $line)
                        <div class="flex justify-between gap-3 text-sm">
                            <span class="text-gray-600">{{ $line->book->title }} <span class="text-gray-400">× {{ $line->quantity }}</span></span>
                            <span class="shrink-0 font-medium text-ink">${{ number_format($line->subtotal, 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <div class="flex justify-between text-base font-bold text-ink">
                        <span>Total</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Users')
@section('heading', 'Users')

@section('content')
    <p class="mb-6 text-sm text-gray-500">{{ $users->total() }} {{ Str::plural('user', $users->total()) }}</p>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead class="bg-canvas text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Role</th>
                        <th class="px-5 py-3">Orders</th>
                        <th class="px-5 py-3">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-canvas">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700">
                                        {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-ink">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize {{ $user->isAdmin() ? 'bg-brand-50 text-brand-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $user->orders_count }}</td>
                            <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('M j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection

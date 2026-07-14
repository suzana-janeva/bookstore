@extends('layouts.admin')

@section('title', 'New book')
@section('heading', 'New book')

@section('content')
    <div class="card max-w-4xl p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.books._form', ['submitLabel' => 'Create book'])
        </form>
    </div>
@endsection

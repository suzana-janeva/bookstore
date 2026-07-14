@extends('layouts.admin')

@section('title', 'Edit book')
@section('heading', 'Edit book')

@section('content')
    <div class="card max-w-4xl p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.books._form', ['submitLabel' => 'Save changes'])
        </form>
    </div>
@endsection

@extends('layout')
@section('content')

<h1>{{ $title }}</h1>
<p>KitePHP is a lightweight development kit with SPA-like powers.</p>

<h2>Test Form (AJAX submission)</h2>
<form action="{{ route('submit') }}" method="POST" kite:submit="submit">
    @csrf
    <label for="name">Your Name</label>
    <input type="text" name="name" id="name" required>
    <button type="submit">Submit</button>
</form>

@endsection

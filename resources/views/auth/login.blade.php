@extends('layouts.auth')
@section('title', $title)
@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <h3 class="text-center text-secondary font-weight-bold mb-3">Login</h1>

        <x-input type="email" name="email" placeholder="Enter Email"/>
        <x-input type="password" name="password" placeholder="Enter Password"/>

        <div>
            <button type="submit" class="btn btn-sm rounded-0 shadow-none btn-primary btn-block">Login</a>
        </div>
    </form>
@endsection

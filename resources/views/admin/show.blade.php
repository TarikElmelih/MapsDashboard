@extends('layouts.app')

@section('content')
    <h1>User Details</h1>
    <p>Name: {{ $users->name }}</p>
    <p>Email: {{ $users->email }}</p>
    <p>Code: {{ $users->code }}</p>
    <p>Role: {{ Auth::user()->is_admin ? 'Admin' : 'User' }}</p>
    <p>Trainer: {{ $users->trainer }}</p>
    <p>Training Type: {{ $users->training }}</p>
    <p>Facilator: {{ $users->facilitator }}</p>
    
   
@endsection

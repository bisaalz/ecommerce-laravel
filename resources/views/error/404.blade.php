@extends('layouts.home')
@section('content')
    <p>
        @if(session('status'))
            {{ session('status') }}
        @endif
    </p>
@endsection

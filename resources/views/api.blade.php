@extends('layouts.app')

@section('script')
@endsection

@section('content')
    <div class="container">
        <h1>API</h1>
        <hr class="div"/>
        <p>This page provides a free to use API for your website. Please be patient for a documentation.</p>
        <p>Go to <a href="{{route('api_index')}}">API</a> to see the available API endpoints. The responses are subject to change, so please don't use right now.</p>
    </div>

@endsection

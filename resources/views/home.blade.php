@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div id="app">
                    <div class="container">
                        @if(Auth::user()->role == "admin")
                            <users auth-token="{{Auth::user()->token}}"></users>
                        @elseif(Auth::user()->role == "standard")
                            <user_details auth-token="{{Auth::user()->token}}" user_id="{{Auth::user()->id}}"></user_details>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

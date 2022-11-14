@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <router-view :user="{{Auth::user()->makeVisible(['aws_auth_token'])}}"/>
    </div>
</div>
@endsection

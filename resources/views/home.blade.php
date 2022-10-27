@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <router-view :user="{{Auth::user()}}"/>
    </div>
</div>
@endsection

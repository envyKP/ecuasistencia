@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">{{' ;) Bienvenido! '}}</h4>
                    <p> {{ Auth::user()->name }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

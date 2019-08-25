@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header text-danger text-center ">Administrator Panel</div>

                <div class="card-body ">
                    <tasks />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

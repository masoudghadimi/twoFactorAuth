@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('home') }}" class="mr-3">{{ __('Dashboard') }}</a>
                        <a href="{{ route('security') }}" class="btn btn-primary">{{ __('Security') }}</a>
                    </div>

                    <div class="card-body">
                        <span class="mt-3"><b>Two-Factor Authenticated :</b>
                            @if(auth()->user()->two_factor_type == 'off')
                                <a href="{{ route('enable.twoFactor') }}" class="btn btn-success ml-3 btn-sm">Enable</a>
                            @else
                                <form action="{{ route('disable.twoFactor') }}" method="post" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-danger ml-3 btn-sm">Disable</button>
                                </form>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

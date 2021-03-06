@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Select Two-Factor Type') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('enable.twoFactor') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Choose Type') }}</label>

                                <div class="col-md-6">
                                    <select id="type" class="form-control" name="two_factor_type" onchange="changeType(event)">
                                        <option value="">Choose...</option>
                                        <option value="sms">SMS</option>
                                        <option value="email">Email</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="phone_number">

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeType(event) {
            let input = document.getElementById('phone_number');

            if (event.target.value === 'sms')
                input.innerHTML =
                    `
                        <label for="phone" class="col-md-4 col-form-label text-md-right">Phone Number</label>

                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control"  name="{{ auth()->user()->phone_number ? '' : 'phone_number' }}" value="{{ auth()->user()->phone_number ?? '' }}" required autofocus>
                            @if(auth()->user()->phone_number)
                                <a id="edit-phone" href="" onclick="changePhoneNumber(event)">Click to edit phone number</a>
                            @endif
                        </div>
                    `
            else
                 input.innerHTML = ''
        }

        function changePhoneNumber(event) {
            event.preventDefault();
            let input = document.getElementById('phone');
            input.value = '';
            input.setAttribute('name' , 'phone_number');
            document.getElementById('edit-phone').style.display = 'none';
        }

    </script>

@endsection

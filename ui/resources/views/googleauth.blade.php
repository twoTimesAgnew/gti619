@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Google Authenticator (2FA)</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p>Enter the following secret key into your Google Authenticator app: {{ $key }}</p>
                    <form method="POST" action="{{ route('confirmOtp') }}">
                        @csrf

                        <div class="row">
                            <label for="otp">Validation Code</label>
                            <input class="form-control" type="text" id="otp" name="otp">
                        </div>

                        <div class="row" style="padding-top:1.5rem">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

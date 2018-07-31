@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Google Authenticator (2FA)</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('validateOtp') }}">
                        @csrf

                        <div class="row">
                            <label for="otp">Please enter your OTP code from Google Authenticator</label>
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

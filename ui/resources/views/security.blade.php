@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css"/>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Security</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row">
                        <label for="pass_attempts">Incorrect password attempts</label>
                        <input class="form-control" type="text" id="pass_attempts" name="pass_attempts" value="{{ $settings->{'pass_attempts'} }}">
                    </div>

                    <div class="row">
                        <label for="pass_attempts_delay">Password attempt delay (in seconds)</label>
                        <input class="form-control" type="text" id="pass_attempts_delay" name="pass_attempts_delay" value="{{ $settings->{'pass_attempts_delay'} }}">
                    </div>

                    <div class="row">
                        <label for="pass_struct">Password constraints</label>
                        <input class="form-control" type="text" id="pass_struct" name="pass_struct" value="{{ $settings->{'pass_struct'} }}">
                    </div>

                    <div class="row">
                        <label for="2fa">Enable 2FA (Google Authenticator)</label>
                    </div>
                    <div class="row">
                        <div class="pretty p-switch">
                            <input type="checkbox"/>
                            <div class="state">
                                <label></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('updateSecurity') }}">
                        @csrf

                        <div class="row">
                            <label for="pass_attempts">Incorrect password attempts</label>
                            <input class="form-control" type="text" id="pass_attempts" name="pass_attempts" value="{{ $settings->{'pass_attempts'} }}">
                        </div>

                        <div class="row">
                            <label for="pass_attempts_delay">Password attempt delay (in seconds)</label>
                            <input class="form-control" type="text" id="pass_attempts_delay" name="pass_attempts_delay" value="{{ $settings->{'pass_attempts_delay'} }}">
                        </div>

                        <div class="row">
                            <label for="pass_max_length">Password max length</label>
                            <input class="form-control" type="text" id="pass_max_length" name="pass_max_length" value="{{ $settings->{'pass_max_length'} }}">
                        </div>

                        <div class="row">
                            <label for="pass_numbers">Allow numbers in password</label>
                        </div>
                        <div class="row">
                            <div class="pretty p-switch">
                                <input type="checkbox" id="pass_numbers" name="pass_numbers" @if(!empty($settings->{'pass_numbers'})) checked @endif/>
                                <div class="state p-primary">
                                    <label></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="pass_special">Allow special characters in password</label>
                        </div>
                        <div class="row">
                            <div class="pretty p-switch">
                                <input type="checkbox" id="pass_special" name="pass_special" @if(!empty($settings->{'pass_special'})) checked @endif/>
                                <div class="state p-primary">
                                    <label></label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="2fa">Enable 2FA (Google Authenticator)</label>
                        </div>
                        <div class="row">
                            <div class="pretty p-switch">
                                <input type="checkbox" id="2fa" name="2fa" @if(!empty($settings->{'2fa'})) checked @endif/>
                                <div class="state p-primary">
                                    <label></label>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-top: 1.5rem">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Password resets</div>

                <div class="card-body">
                    @if (session('passMessage'))
                        <div class="alert alert-success" role="alert">
                            {{ session('passMessage') }}
                        </div>
                    @endif

                    @if (session('passError'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('passError') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('updatePassword') }}">
                        @csrf

                        <div class="row">
                            <label for="id">Select a user</label>
                            <select class="form-control" id="id" name="id">
                                <option value="2">Utilisateur1</option>
                                <option value="3">Utilisateur2</option>
                            </select>
                        </div>

                        <div class="row">
                            <label for="password">Enter New Password</label>
                            <input class="form-control" type="password" id="password" name="password">
                        </div>

                        <div class="row">
                            <label for="confirmPassword">Confirm Password</label>
                            <input class="form-control" type="password" id="confirmPassword" name="confirmPassword">
                        </div>

                        <div class="row" style="padding-top: 1.5rem">
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">User salts</div>

                <div class="card-body">
                    <div class="row">
                        <label for="user1">Administrateur (hash type: {{ $hashes[0] }})</label>
                        <input class="form-control" type="text" id="user1" value="{{$salts[0]}}" disabled>
                    </div>

                    <div class="row">
                        <label for="user2">Utilisateur1 (hash type: {{ $hashes[1] }})</label>
                        <input class="form-control" type="text" id="user2" value="{{$salts[1]}}" disabled>
                    </div>

                    <div class="row">
                        <label for="user3">Utilisateur2 (hash type: {{ $hashes[2] }})</label>
                        <input class="form-control" type="text" id="user3" value="{{$salts[2]}}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

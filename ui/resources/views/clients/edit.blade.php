@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Client</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="col-md-12">
                            <form method="POST" action="{{route('update')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $client['id'] }}">
                                <div class="row">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{ $client['name'] }}">
                                </div>
                                <div class="row" style="padding-top: 1.5rem">
                                    <label for="type">Type</label>
                                    <select id="type" name="type" class="form-control">
                                        @if(session()->get('username') == 'Administrateur' || session()->get('username') == 'Utilisateur1')
                                            <option value="1" @if($client['type'] == 1) selected @endif>Residential</option>
                                        @endif
                                        @if(session()->get('username') == 'Administrateur' || session()->get('username') == 'Utilisateur2')
                                            <option value="2" @if($client['type'] == 2) selected @endif>Business</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="row" style="padding-top: 1.5rem">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
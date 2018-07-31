@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Client</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="col-md-12">
                            <form method="POST" action="{{route('create')}}">
                                @csrf
                                <div class="row">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="eg. John Doe">
                                </div>
                                <div class="row" style="padding-top: 1.5rem">
                                    <label for="type">Type</label>
                                    <select id="type" name="type" class="form-control">
                                        @if(session()->get('username') == 'Administrateur' || session()->get('username') == 'Utilisateur1')
                                            <option value="1">Residential</option>
                                        @endif
                                        @if(session()->get('username') == 'Administrateur' || session()->get('username') == 'Utilisateur2')
                                            <option value="2">Business</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="row" style="padding-top: 1.5rem">
                                    <button type="submit" class="btn btn-success">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
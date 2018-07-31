@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Business Clients</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="row" style="padding: 1.5rem 0 1.5rem 1.5rem">
                            <a href="{{ route('addClient') }}" class="btn btn-success">Add client</a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($clients))
                                @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client['id']}}</td>
                                        <td>{{$client['name']}}</td>
                                        <td>Business</td>
                                        <td>
                                            <form action="{{route('edit')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $client['id'] }}">
                                                <button class="btn btn-warning" type="submit">Edit</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{route('delete')}}" method="post">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <input type="hidden" name="id" value="{{ $client['id'] }}">
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
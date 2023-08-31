@extends('layouts.login')

@section("title", "Login")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 p-3">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ url('/', []) }}" class="btn btn-secondary my-2 ">Kembali</a>
                        <h4 class="py-0 my-0">
                            LOGIN
                        </h4>
                    </div>
    
                    <form action="{{ route('login', []) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input id="username" class="form-control" type="text" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" class="form-control" type="password" name="password">
                            </div>
                        </div>
        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">MASUK</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
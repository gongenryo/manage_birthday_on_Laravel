@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Birthday</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('birthday.store') }}">
                    @csrf
                    氏名
                    <input type="text" name="name">
                    <br>
                    誕生日
                    <input type="date" name="birthday" value="1999-04-01">
                    <br>
                    <input class="btn btn-primary" type="submit" value="登録する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
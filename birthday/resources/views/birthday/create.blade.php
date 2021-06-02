@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">新規作成</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('birthday.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">氏名</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" class="form-controll">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="birthday" class="col-sm-2 col-form-label">誕生日</label>
                            <div class="col-sm-10">
                                <input type="date" name="birthday" value="1999-04-01" id="birthday" placefolder="2000-04-01" class="form-controll">
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="登録する">
                    </form>
                </div>      
            </div>
        </div>
    </div>
</div>
@endsection
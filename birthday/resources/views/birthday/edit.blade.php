@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $friend->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('birthday.update', ['id' => $friend->id]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">名前</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-controll" id="name" value="{{ $friend->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday" class="col-sm-2 col-form-label">誕生日</label>
                            <div class="col-sm-10">
                                <input type="date" name="birthday" class="form-controll" id="birthday" value="{{ $friend->birthday }}">
                            </div>
                        </div>

                    <input class="btn btn-primary" type="submit" value="更新する">
                    </form>

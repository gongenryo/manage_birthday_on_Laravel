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

                    <div class="row">
                        <label class="col-md-2">名前</label>
                        <label class="col-md-10">{{ $friend->name }}</label>
                    </div>
                    <div class="row">
                        <label class="col-md-2">誕生日</label>
                        <label class="col-md-10">{{ $friend->birthday}}</label>
                    </div>
                    <div class="row">
                        <form method="GET" action="{{ route('birthday.edit', [ 'id' => $friend->id ]) }}" class="col-md-2">
                        @csrf
                        <input class="btn btn-primary" type="submit" value="変更する">
                        </form>

                        <form method="POST" action="{{ route('birthday.destroy', [ 'id' => $friend->id ]) }}" id="delete_{{ $friend->id }}" class="col-md-2">
                        @csrf
                        <a href="#" class="btn btn-danger" data-id="{{ $friend->id }}" onclick="deletePost(this);" >削除する</a>                    
                        </form>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<script>
function deletePost(e){
  'use strict';
  if (confirm('本当に削除していいですか？')) {
    document.getElementById('delete_' + e.dataset.id).submit();
  }
}
</script>
@endsection
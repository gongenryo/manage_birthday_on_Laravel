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

                    名前 {{ $friend->name}}
                    <br>
                    誕生日 {{ $friend->birthday }}
                    <br>
                    <form method="GET" action="{{ route('birthday.edit', [ 'id' => $friend->id ]) }}">
                    @csrf
                    <input class="btn btn-primary" type="submit" value="変更する">
                    </form>

                    <form method="POST" action="{{ route('birthday.destroy', [ 'id' => $friend->id ]) }}" id="delete_{{ $friend->id }}">
                    @csrf
                    <a href="#" class="btn btn-danger" data-id="{{ $friend->id }}" onclick="deletePost(this);" >削除する</a>                    
                    </form>
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
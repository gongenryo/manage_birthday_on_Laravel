@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">誕生日一覧</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">氏名</th>
                            <th scope="col">誕生日</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($index_lists as $index_list)
                            <tr>
                            <th>{{ $index_list->name }}</th>
                            <td>{{ $index_list->birthday }}</td>
                            <td><a href="{{ route('birthday.show', ['id' =>  $index_list->id ]) }}">詳細を見る</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form methodd="GET" action="{{ route('birthday.create') }}">
                    <button type="submit" class="btn btn-primary">
                    新規登録
                    </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

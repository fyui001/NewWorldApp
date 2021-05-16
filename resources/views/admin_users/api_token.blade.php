@extends('layouts.base', ['activePage' => 'AdminUser'])

@section('content-header')
    <div>
        <h3>
            <span class="oi oi-person"></span>
            API TOKEN
        </h3>
        <div class="text-right">
            <a href="{{ route('top_page') }}" class="btn btn-round btn-info">
                <span class="oi oi-chevron-left"></span>
                トップページに戻る
            </a>
        </div>
    </div>
@endsection

@section('content')
<table class="table">
    <tr>
         <td>API TOKEN</td>
        <td>{{ $apiToken  }}</td>
    </tr>
</table>
{{ Form::open(['url' => route('admin_users.api_token.update'), 'method' => 'post'])  }}
    <button type="submit" class="btn btn-round btn-info">更新</button>
{{ Form::close() }}
@endsection

@extends('layouts.base', ['activePage' => 'Drug'])

@section('content-header')
<div>
    <h3>
        <span class="oi oi-eye"></span>
        薬物一覧（全{{ $drugs->count() }}件）
    </h3>
    <div class="text-right">
        <a href="{{ route('drugs.create') }}" class="btn btn-round btn-info" rel="tooltip">
            <span class="oi oi-plus"></span> 新規作成
        </a>
    </div>
</div>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>薬物名</th>
            <th>Wiki Source</th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    @foreach($drugs as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->drug_name }}</td>
            <td>
                <a href="{{ $item->url }}" target="_blank" rel="noopener noreferrer">
                    {{ mb_substr($item->url, 0, 40) }}
                </a>
            </td>
            <td class="td-actions text-right">
                <a href="{{ route('drugs.edit', $item) }}" class="btn btn-success btn-round" rel="tooltip" data-placement="bottom" title="Edit">
                    <span class="oi oi-pencil"></span>
                </a>
            </td>
        </tr>
    @endforeach
</table>
<div class="box-footer clearfix">
    {!! $drugs->links('pagination::bootstrap-4') !!}
</div>
@endsection

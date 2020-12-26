@extends('layouts.base', ['activePage' => 'MedicationHistory'])

@section('content-header')
<div>
    <h3>
        <span class="oi oi-eye"></span>
        服薬履歴（全{{ $medicationHistories->count() }}件）
    </h3>
</div>
@endsection

@section('content')
<table class="table">
    <thead>
    <tr>
        <th class="text-center">#</th>
        <th>服薬者</th>
        <th>薬物名</th>
        <th>量(mg)</th>
        <th>服薬日時</th>
    </tr>
    </thead>
    @foreach($medicationHistories as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->drug->drug_name }}</td>
        <td>{{ $item->amount }}</td>
        <td>{{ $item->created_at }}</td>
    </tr>
    @endforeach
</table>
<div class="box-footer clearfix">
    {!! $medicationHistories->links('pagination::bootstrap-4') !!}
</div>
@endsection

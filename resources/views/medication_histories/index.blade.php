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
        <th class="text-center">@sortablelink('id', '#')</th>
        <th>服薬者</th>
        <th>薬物名</th>
        <th>量(mg)</th>
        <th>服薬日時</th>
        <th class="text-right">Action</th>
    </tr>
    </thead>
    @foreach($medicationHistories as $item)
        <?php /** @var Infra\EloquentModels\MedicationHistory $item */ ?>
    <tr>
        <td>{{ $item->toDomain()->getId()->getRawValue() }}</td>
        <td>{{ $item->user->toDomain()->getName()->getRawValue() }}</td>
        <td>{{ $item->drug->toDomain()->getName()->getRawValue() }}</td>
        <td>{{ $item->toDomain()->getAmount() }}</td>
        <td>{{ $item->created_at }}</td>
        <td class="td-actions text-right">
            <a href="{{ route('medication_histories.edit', $item) }}" class="btn btn-success btn-round" rel="tooltip" data-placement="bottom" title="Edit">
                <span class="oi oi-pencil"></span>
            </a>
        </td>
    </tr>
    @endforeach
</table>
<div class="box-footer clearfix">
    {!! $medicationHistories->appends(request()->query())->links('pagination::bootstrap-4') !!}
</div>
@endsection

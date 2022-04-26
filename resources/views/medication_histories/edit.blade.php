@extends('layouts.base', ['activePage' => 'MedicationHistory'])

@section('content-header')
    <div>
        <h3>
            <span class="oi oi-eye"></span>
            服薬履歴編集
        </h3>
        <div class="text-right">
            <a href="{{ route('admin.medication_histories.index') }}" class="btn btn-round btn-info">
                <span class="oi oi-chevron-left"></span>
                服薬履歴一覧に戻る
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{ Form::open(['url' => route('admin.medication_histories.update', $medicationHistory), 'method' => 'post']) }}
    <div class="form-group info">
        <label>服薬者</label>
        {{ Form::text('taker', old('', $medicationHistory->user->name), ['class' => 'form-control', 'placeholder' => 'Enter Taker', 'disabled' => true]) }}
    </div>
    <div class="form-group info">
        <label>薬物名</label>
        {{ Form::text('drug_name', old('drug_name', $medicationHistory->drug->drug_name), ['class' => 'form-control', 'placeholder' => 'Enter drug name', 'disabled' => true]) }}
    </div>
    <div class="form-group info">
        <label>服薬用</label>
        {{ Form::text('amount', old('amount', $medicationHistory->amount), ['class' => 'form-control', 'placeholder' => 'Enter amount', 'require' => true]) }}
    </div>
    <button type="submit" class="btn btn-round btn-info">更新</button>
    {{ Form::close() }}
@endsection

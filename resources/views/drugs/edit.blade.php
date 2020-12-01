@extends('layouts.base', ['activePage' => 'Drug'])

@section('content-header')
    <div>
        <h3>
            <span class="oi oi-eye"></span>
            薬物編集
        </h3>
        <div class="text-right">
            <a href="{{ route('drugs.index') }}" class="btn btn-round btn-info">
                <span class="oi oi-chevron-left"></span>
                薬物一覧に戻る
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{ Form::open(['url' => route('drugs.update', $drug), 'method' => 'post']) }}
    <div class="form-group info">
        <label>薬物名</label>
        {{ Form::text('drug_name', old('drug_name', $drug->drug_name), ['class' => 'form-control', 'placeholder' => 'Enter drug name', 'required' => true]) }}
    </div>
    <div class="form-group info">
        <label>URL (wiki)</label>
        {{ Form::text('url', old('url', $drug->url), ['class' => 'form-control', 'placeholder' => 'Enter URL', 'required' => true]) }}
    </div>
    <button type="submit" class="btn btn-round btn-info">更新</button>
    {{ Form::close() }}
@endsection

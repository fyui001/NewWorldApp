@extends('layouts.base', ['activePage' => 'Drug'])

@section('content-header')
<div>
    <h3>
        <span class="oi oi-eye"></span>
        薬物登録
    </h3>
    <div class="text-right">
        <a href="{{ route('admin.drugs.index') }}" class="btn btn-round btn-info">
            <span class="oi oi-chevron-left"></span>
            薬物一覧に戻る
        </a>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('admin.drugs.store') }}" method="POST">
    <div class="form-group info">
        <label>薬物名</label>
        <input name="drug_name" value="{{ old('drug_name') }}" class="form-control " placeholder="Enter drug name" required/>
    </div>
    <div class="form-group info">
        <label>URL (wiki)</label>
        <input name="url" value="{{ old('url') }}" class="form-control " placeholder="Enter URL" required/>
    </div>
    <button type="submit" class="btn btn-round btn-info">追加</button>
</form>
@endsection

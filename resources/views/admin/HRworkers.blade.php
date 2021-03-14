@extends('layouts.admin')

@section('content')

<h1>Список сотрудников отделов кадров</h1>

<div class="text-danger">
    {{ session('success') }}
</div>

{{ $HRworkers->links() }}

<div class="row">
    <div class="col-3 border text-center"><b>Фамилия Имя Отчество</b></div>
    <div class="col-3 border text-center"><b>Организация</b></div>
    <div class="col-3 border text-center"><b>Телефон</b></div>
    <div class="col-3 border text-center"><b>E-mail</b></div>
</div>


@forelse($HRworkers as $HRworker)

    <div class="row">
        <div class="col-3 border text-center">
            <a href="{{route('user',$id=$HRworker->user_id)}}">
            {{$HRworker->secondName}} {{$HRworker->firstName}} {{$HRworker->middleName}}
            </a>
        </div>
        <div class="col-3 border text-center">
            <a href="{{route('admin.company',$id=$HRworker->company_id)}}">{{$HRworker->company_name}}</a>
        </div>
        <div class="col-3 border text-center">
            {{$HRworker->phone}}
        </div>
        <div class="col-3 border text-center">
            {{$HRworker->email}}
        </div>

    </div>

@empty
    <h3>Сотрудники не найдены</h3>
@endforelse

{{ $HRworkers->links() }}

@stop

@extends('layouts.hr')

@section('content')

    <div class="row">
        <div class="col-8">
            <h1>Организация: {{ $company->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-8"><h2>Подразделения</h2></div>

        @forelse($departments as $department)
            <div class="col-8">
                <p class="border border-primary"><a href="#"><h5>{{$department->name}}</h5></a>
                    <a href="#" class="badge badge-danger">Удалить</a>
                    <a href="#" class="badge badge-primary">Переименовать</a>
                </p>
            </div>
            @empty
                <div class="col-8">
                    <h3>Подразделений не найдено</h3>
                </div>
            @endforelse

    </div>

    <a href="#" type="button" class="btn btn-primary">Добавить подразделение</a>
@stop

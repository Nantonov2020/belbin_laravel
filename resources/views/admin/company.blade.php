@extends('layouts.admin')

@section('content')

    @empty($company->name)
        Организация не найдена.
    @endempty

    @isset($company->name)
    <h1>{{$company->name}}</h1>


    @if ($company->is_delete)
        <div class="alert alert-danger" role="alert">
            Данная компания помечена как удалённая!
        </div>
    @endif

    <div class="row">
        <div class="col-6 border">
            <h5> Подразделения организации:</h5>
            <hr>
            @foreach($departments as $department)
                <div class="row">
                    <div class="col-10">
                        <a href="{{route('department', $id = $department->id)}}">{{$department->name}}</a>
                    </div>
                </div>
            @endforeach
            <a href="{{route('admin.addDepartment')}}" type="button" class="btn btn-primary">Добавить подразделение</a>
        </div>
        <div class="col-6 border">
            <h5> Сотрудники отдела кадров:</h5>
            <hr>
            @foreach($hrworkers as $hrworker)
                <div class="row">
                    <div class="col-10">
                        <a href="{{route('user',$id=$hrworker->user_id)}}">
                        @isset($hrworker->secondName)
                            {{$hrworker->secondName}}
                        @endisset

                        @isset($hrworker->firstName)
                            {{$hrworker->firstName}}
                        @endisset

                        @isset($hrworker->middleName)
                            {{$hrworker->middleName}}
                        @endisset
                        </a>
                        @isset($hrworker->phone)
                            ({{$hrworker->phone}})
                        @endisset
                    </div>
                </div>
            @endforeach
            <a href="{{route('addUserForm')}}" type="button" class="btn btn-primary">Добавить сотрудника</a>
        </div>
    </div>

    @endisset

@stop





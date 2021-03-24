@extends('layouts.hr')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-danger">
                        {{ session('success') }}
                    </div>

                    @empty($user)
                        Пользователь не найден.<br>

                        <div class="col-6"><a href="{{ route('hr.findUser', $idCompany) }}" type="button" class="btn btn-primary">Вернуться к поиску</a>

                        </div>
                    @endempty

                    @isset($user)

                    <div class="card-header">Страница пользователя</div>

                    @if($user->is_admin)
                        <div class="alert alert-success" role="alert">
                            Пользователь является администратором
                        </div>
                    @endif

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Логин</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ $user->email }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="secondName" class="col-md-4 col-form-label text-md-right">Фамилия</label>

                            <div class="col-md-6">
                                <input id="secondName" type="text" class="form-control" name="secondName" value="{{ $user->secondName }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstName" class="col-md-4 col-form-label text-md-right">Имя</label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control" name="firstName" value="{{ $user->firstName }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middleName" class="col-md-4 col-form-label text-md-right">Отчество</label>

                            <div class="col-md-6">
                                <input id="middleName" type="text" class="form-control" name="middleName" value="{{ $user->middleName }}" readonly>
                            </div>
                        </div>

                        <hr>
                        <p class="text-center">
                            <a href="{{route('hr.giveStatusHR', ['idCompany' => $idCompany, 'idUser' => $user->id])}}" class="btn btn-primary pull-right btn-sm" title="Сделать HR">
                                Сделать HR
                            </a>
                            &nbsp;
                            <a href="{{route('hr.giveStatusWorker', ['idCompany' => $idCompany, 'idUser' => $user->id])}}" class="btn btn-primary pull-right btn-sm">
                                Сделать сотрудником
                            </a>
                        </p>

                    </div>
                    @endisset

                </div>
            </div>
        </div>
    </div>

@stop

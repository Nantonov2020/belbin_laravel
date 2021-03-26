@extends('layouts.hr')

@section('content')

    <div class="row">
        <div class="col-6"><h1>Список HR сотрудников предприятия</h1></div>
    </div>

    <div class="text-danger">
        {{ session('success') }}
    </div>

    <div class="row">
        <div class="col-3 border text-center"><b>Фамилия</b></div>
        <div class="col-2 border text-center"><b>Имя</b></div>
        <div class="col-2 border text-center"><b>Отчество</b></div>
        <div class="col-2 border text-center"><b>E-mail</b></div>
        <div class="col-3 border text-center"><b>Действия</b></div>
    </div>

    @forelse($HRWorkers as $user)

        <div class="row">

            <div class="col-3 border text-center">

                    @empty($user->secondName)
                        -
                    @endempty
                    {{$user->secondName}}

            </div>
            <div class="col-2 border text-center">

                    @empty($user->firstName)
                        -
                    @endempty
                    {{$user->firstName}}

            </div>
            <div class="col-2 border text-center">

                    @empty($user->middleName)
                        -
                    @endempty
                    {{$user->middleName}}

            </div>
            <div class="col-2 border text-center">

                    {{$user->email}}

            </div>

            <div class="col-3 border text-center">

                <a href="{{route('hr.deleteStatusHR', ['idUser'=>$user->id, 'idCompany' => $idCompany])}}" class="btn btn-sm bg-transparent" onClick='return confirm("Действительно желаете удалить статус HR у данного сотрудника?")' title="Удалить статус HR">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-danger bi bi-x-octagon-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                    </svg>
                </a>

            </div>
        </div>

    @empty
        <h3>Пользователи не найдены</h3>
    @endforelse

@stop

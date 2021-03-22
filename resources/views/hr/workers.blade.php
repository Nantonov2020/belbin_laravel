@extends('layouts.hr')

@section('content')

    <div class="row">
        <div class="col-8"><h1>Список сотрудников</h1></div>
        <div class="col-4"><a href="{{route('addUserForm')}}" type="button" class="btn btn-primary">Добавить сотрудника</a>

        </div>
    </div>
    <div class="text-danger">
        {{ session('success') }}
    </div>

    {{ $workers->links() }}

    <div class="row">
        <div class="col-2 border text-center"><b>Фамилия</b></div>
        <div class="col-2 border text-center"><b>Имя</b></div>
        <div class="col-2 border text-center"><b>Отчество</b></div>
        <div class="col-2 border text-center"><b>E-mail</b></div>
        <div class="col-2 border text-center"><b>Аттрибуты</b></div>
        <div class="col-2 border text-center"><b>Действия</b></div>
    </div>

    <form action="{{route('searchUser')}}" method="GET">
        @csrf

        <div class="row">
            <div class="col-2 border text-center">

                <input type="text" name="secondName" value="{{old('secondName')}}" class="w-100">
                @error('secondName')
                <div class="alert alert-danger">
                    @foreach($errors->get('secondName') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror

            </div>
            <div class="col-2 border text-center">

                <input type="text" name="firstName" value="{{old('firstName')}}" class="w-100">
                @error('firstName')
                <div class="alert alert-danger">
                    @foreach($errors->get('firstName') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror


            </div>
            <div class="col-2 border text-center">

                <input type="text" name="middleName" value="{{old('middleName')}}" class="w-100">
                @error('middleName')
                <div class="alert alert-danger">
                    @foreach($errors->get('middleName') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror


            </div>
            <div class="col-2 border text-center">

                <input type="text" name="email" value="{{old('email')}}" class="w-100">
                @error('email')
                <div class="alert alert-danger">
                    @foreach($errors->get('email') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror


            </div>
            <div class="col-2 border text-center">
                <select name="attribute" id="attribute" class="w-100">
                    <option value="0" selected>-</option>
                    <option value="1">Руководитель</option>
                    <option value="2">Кандидат</option>
                </select>
                @error('attribute')
                <div class="alert alert-danger">
                    @foreach($errors->get('attribute') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror

            </div>

            <div class="col-2 border text-center">
                <button type="submit" class="btn btn-primary pull-right btn-sm">
                    Поиск
                </button>
            </div>

        </div>
    </form>

    @forelse($workers as $user)

        <div class="row">

            <div class="col-2 border text-center">
                <a href="{{route('hr.worker',$idWorker=$user->id)}}">
                    @empty($user->secondName)
                        -
                    @endempty
                    {{$user->secondName}}
                </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('hr.worker',$idWorker=$user->id)}}">
                    @empty($user->firstName)
                        -
                    @endempty
                    {{$user->firstName}}
                </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('hr.worker',$idWorker=$user->id)}}">
                    @empty($user->middleName)
                        -
                    @endempty
                    {{$user->middleName}}
                </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('hr.worker',$idWorker=$user->id)}}">
                    {{$user->email}}
                </a>
            </div>

            <div class="col-2 border text-center">
                @if($user->is_candidate)
                    <span class="badge badge-primary">Кандидат</span>
                @endif
                @if($user->is_head)
                    <span class="badge badge-success">Руководитель</span>
                @endif

                -
            </div>
            <div class="col-2 border text-center">

                <a href="{{route('giveStatusHR', $id=$user->id)}}" class="btn btn-sm bg-transparent" title="Сделать HR">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-primary bi bi-briefcase-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                        <path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5v1.384l-7.614 2.03a1.5 1.5 0 0 1-.772 0L0 5.884V4.5zm5-2A1.5 1.5 0 0 1 6.5 1h3A1.5 1.5 0 0 1 11 2.5V3h-1v-.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V3H5v-.5z"/>
                    </svg>
                </a>

                <a href="{{route('correctUser',$id=$user->id)}}" class="btn btn-sm bg-transparent" title="Редактировать">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-primary bi bi-wrench" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"/>
                    </svg>
                </a>

            </div>
        </div>

    @empty
        <h3>Пользователи не найдены</h3>
    @endforelse

    {{ $workers->links() }}

@stop

@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-8"><h1>Список пользователей</h1></div>
        <div class="col-4"><a href="{{route('addUserForm')}}" type="button" class="btn btn-primary">Добавить пользователя</a>

        </div>
    </div>
    <div class="text-danger">
        {{ session('success') }}
    </div>

    {{ $users->links() }}

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
                <option value="1">Администратор</option>
                <option value="2">Сотрудник HR</option>
                <option value="3">Руководитель</option>
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

    @forelse($users as $user)

        <div class="row">

            <div class="col-2 border text-center">
                    <a href="{{route('user',$id=$user->id)}}">
                    @empty($user->secondName)
                    -
                @endempty
                {{$user->secondName}}
                    </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('user',$id=$user->id)}}">
                @empty($user->firstName)
                    -
                @endempty
                {{$user->firstName}}
                </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('user',$id=$user->id)}}">
                @empty($user->middleName)
                    -
                @endempty
                {{$user->middleName}}
                </a>
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('user',$id = $user->id)}}">
                {{$user->email}}
                </a>
            </div>

            <div class="col-2 border text-center">
                @if($user->is_admin)
                    <span class="badge badge-primary">Admin</span>
                @endif
                -
            </div>
            <div class="col-2 border text-center">
                <a href="{{route('deleteUser', $id=$user->id)}}" onClick='return confirm("Действительно желаете удалить пользователя?")' class="btn btn-sm bg-transparent delete" title="Удалить">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-danger bi bi-x-octagon-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                </svg>
                </a>

                <a href="{{route('giveStatusHR', $id=$user->id)}}" class="btn btn-sm bg-transparent" title="Сделать HR">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-primary bi bi-briefcase-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                    <path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5v1.384l-7.614 2.03a1.5 1.5 0 0 1-.772 0L0 5.884V4.5zm5-2A1.5 1.5 0 0 1 6.5 1h3A1.5 1.5 0 0 1 11 2.5V3h-1v-.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V3H5v-.5z"/>
                </svg>
                </a>

                @if (($user->is_admin) == false)
                    <a href="{{route('makeAdmin', $id=$user->id)}}" class="btn btn-sm bg-transparent" onClick='return confirm("Действительно желаете сделать данного пользователя администратором?")' title="Сделать Администратором">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-success bi bi-badge-ad-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm6.209 6.32c0-1.28.694-2.044 1.753-2.044.655 0 1.156.294 1.336.769h.053v-2.36h1.16V11h-1.138v-.747h-.057c-.145.474-.69.804-1.367.804-1.055 0-1.74-.764-1.74-2.043v-.695zm3.142.017c0-.699-.422-1.138-1.002-1.138-.584 0-.954.444-.954 1.239v.453c0 .8.374 1.248.972 1.248.588 0 .984-.44.984-1.2v-.602zM4.17 9.457L3.7 11H2.5l2.013-5.999H5.9L7.905 11H6.644l-.47-1.542H4.17zm1.767-.883l-.734-2.426H5.15l-.734 2.426h1.52z"/>
                    </svg>
                    </a>
                @endif

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

    {{ $users->links() }}
@stop



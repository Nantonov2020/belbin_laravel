@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-danger">
                        {{ session('success') }}
                    </div>
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
                        @isset($worker[0])
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right"><b>Пользователь является сотрудником следующих предприятий:</b></label>
                            </div>
                        @endisset

                        @forelse($worker as $item)
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right"><a href="{{route('admin.company',$id=$item->company_id)}}">{{$item->name}}</a>
                                    <br>(<a href="{{route('department',$id=$item->id_department)}}">{{$item->name_department}}</a>)

                                    @if($item->is_head)
                                        (Руководитель)
                                    @endif

                                    @if($item->is_candidate)
                                        (Кандидат)
                                    @endif

                                    <a href="{{route('deleteStatusWorker',['id'=>$user->id,'id_department'=>$item->id_department])}}" onClick='return confirm("Действительно желаете удалить пользователя из данного подразделения?")' class="btn btn-sm bg-transparent delete" title="Удалить">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-danger bi bi-x-octagon-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                        </svg>
                                    </a>

                                </label>
                            </div>
                        @empty
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right">Пользователь не является сотрудником ни одного предприятия</label>
                            </div>
                        @endforelse

                        <hr>
                        @isset($HRworker[0])
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right"><b>Пользователь является HR сотрудником следующих предприятий:</b></label>
                            </div>
                        @endisset

                        @forelse($HRworker as $item)
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right"><a href="{{route('admin.company',$id=$item->company_id)}}">{{$item->name}}</a>

                                    <a href="{{route('deleteStatusHRworker',['id'=>$user->id,'id_company'=>$item->company_id])}}" onClick='return confirm("Действительно желаете убрать статус HR данного пользователя?")' class="btn btn-sm bg-transparent delete" title="Удалить">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-danger bi bi-x-octagon-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                    </svg>
                                    </a>

                                </label>
                            </div>
                        @empty
                            <div class="form-group row">
                                <label class="col-md-10 col-form-label text-md-right">Пользователь не является HR-сотрудником ни одного предприятия</label>
                            </div>
                        @endforelse
                        <hr>
                        <p class="text-center">
                            <a href="{{route('giveStatusHR', $id=$user->id)}}" class="btn btn-primary pull-right btn-sm" title="Сделать HR">
                                Сделать HR
                            </a>
                            &nbsp;

                            @if ($user->is_admin)
                                <a href="{{route('deleteStatusAdmin',$id=$user->id)}}" class="btn btn-primary pull-right btn-sm" onClick='return confirm("Действительно желаете убрать статус администратора?")' title="Сделать Администратором">
                                    Убрать статус администратора
                                </a>
                            @else
                                <a href="{{route('makeAdmin', $id=$user->id)}}" class="btn btn-primary pull-right btn-sm" onClick='return confirm("Действительно желаете сделать данного пользователя администратором?")' title="Сделать Администратором">
                                    Сделать администратором
                                </a>
                            @endif
                            &nbsp;
                            <a href="{{route('correctUser', $id=$user->id)}}" class="btn btn-primary pull-right btn-sm">
                                Редактировать
                            </a>
                            &nbsp;
                            <a href="{{route('makeWorker', $id=$user->id)}}" class="btn btn-primary pull-right btn-sm">
                                Сделать сотрудником
                            </a>

                            &nbsp;
                            <a href="{{route('deleteUser', $id=$user->id)}}" class="btn btn-danger pull-right btn-sm" onClick='return confirm("Действительно желаете безвозвратно удалить пользователя?")'>
                                Удалить
                            </a>


                        </p>


                    </div>
                </div>
            </div>
        </div>
    </div>



@stop

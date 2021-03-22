@extends('layouts.admin')

@section('content')

    <div class="container">

        @if ($department->is_delete)
            <div class="alert alert-danger" role="alert">
                Данное подразделение помечено как удаленное
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-danger">
                        {{ session('success') }}
                    </div>
                    <div class="card-header">Страница подразделения</div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Наименование подразделения</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{$department->name}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Наименование Организации</label>

                            <div class="col-md-6">
                                <a href="{{route('admin.company',$id=$department->company_id)}}">{{$department->company_name}}</a>
                            </div>
                        </div>
                        <hr>

                        @isset($workers[0])
                            <div class="form-group row">
                                <label class="col-md-12 col-form-label text-md-center"><b>Сотрудники подразделения:</b></label>
                            </div>
                        @endisset

                        @forelse($workers as $item)

                            <a href="{{route('user',$id=$item->id)}}">{{ $item->secondName }} {{ $item->firstName }} {{ $item->middleName }}</a>

                            @if($item->is_head)
                                (Руководитель)
                            @endif

                            @if($item->is_candidate)
                                (Кандидат)
                            @endif

                            <a href="{{route('deleteStatusWorker',['id'=>$item->id,'id_department'=>$department->department_id])}}" onClick='return confirm("Действительно желаете удалить пользователя из данного подразделения?")' class="btn btn-sm bg-transparent delete" title="Удалить">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="text-danger bi bi-x-octagon-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                                </svg>
                            </a>


                            <br>

                        @empty
                            В данном подразделении нет сотрудников
                        @endforelse

                        <hr>

                        <p class="text-center">
                            &nbsp;
                            <a href="{{route('admin.renameDepartment',$id=$department->department_id)}}" class="btn btn-primary pull-right btn-sm">
                                Редактировать
                            </a>
                            &nbsp;
                            @if ($department->is_delete)
                                <a href="{{route('admin.restoreDepartment',['id'=>$department->department_id])}}" class="btn btn-danger pull-right btn-sm" onClick='return confirm("Действительно желаете восстановить данное подразделение?")'>
                                    Восстановить
                                </a>
                            @else
                                <a href="{{route('admin.deleteDepartment',['id'=>$department->department_id])}}" class="btn btn-danger pull-right btn-sm" onClick='return confirm("Действительно желаете удалить данное подразделение?")'>
                                    Удалить
                                </a>
                            @endif

                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

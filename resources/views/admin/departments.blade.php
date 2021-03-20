@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-6"><h1>Подразделения</h1></div>
        <div class="col-6">
            <form action="{{route('findDepartment')}}" method="GET">
                @csrf
                <div class="d-flex p-2 bd-highlight justify-content-end">
                    <div class="col-5"><input type="text" name="name" class="form-control " required="required" placeholder="Поиск: наименование подразделения"></div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-primary pull-right">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-danger">
        {{ session('success') }}
    </div>

    {{ $departments->links() }}

    @forelse($departments as $department)
        <p class="border border-primary"><a href="{{route('department',$id = $department->id)}}"><h5>{{$department->name}}</h5></a>
        <h6 class="text-success">Организация: <a href="{{route('admin.company',$id = $department->idCompany)}}">{{$department->nameCompany}}</a></h6>
            @if ($department->is_delete)
                <span class="badge badge-info">Удалена</span>
                <a href="{{route('admin.restoreDepartment',['id'=>$department->id])}}" class="badge badge-success">Восстановить</a>
            @else
                <a href="{{route('admin.deleteDepartment',['id'=>$department->id])}}" class="badge badge-danger">Удалить</a>
                <a href="{{route('admin.renameDepartment',$id = $department->id)}}" class="badge badge-primary">Переименовать</a>
            @endif
        </p>
    @empty
        <h3>Подразделений не найдено</h3>
    @endforelse
    {{ $departments->links() }}
    <a href="{{route('admin.addDepartment')}}" type="button" class="btn btn-primary">Добавить подразделение</a>
@stop

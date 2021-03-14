@extends('layouts.admin')

@section('content')


<div class="row">
    <div class="col-6"><h1>Компании</h1></div>
    <div class="col-6">
        <form action="{{route('findCompany')}}" method="POST">
            @csrf
            <div class="d-flex p-2 bd-highlight justify-content-end">
                <div class="col-5"><input type="text" name="name" class="form-control " required="required" placeholder="Поиск: наименование организации"></div>
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

{{ $companies->links() }}
    @forelse($companies as $company)
        <p class="border border-primary"><a href="{{route('admin.company', $company->id)}}"><h3>{{$company->name}}</h3></a>
            @if ($company->is_delete)
                <span class="badge badge-info">Удалена</span>
                <a href="{{route('admin.deletecompany',['id'=>$company->id, 'type'=>false])}}" class="badge badge-success">Восстановить</a>
            @else
                <a href="{{route('admin.deletecompany',['id'=>$company->id, 'type'=>true])}}" class="badge badge-danger">Удалить</a>
                <a href="{{route('admin.renamecompany',$id = $company->id)}}" class="badge badge-primary">Переименовать</a>
            @endif
        </p>
    @empty
        <h3>Компаний не найдено</h3>
    @endforelse
    {{ $companies->links() }}

    <h3>Добавить организацию</h3>
    <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{route('company.store')}}">
        @csrf
        <div class="form-group col-md-6">
            <input type="text" name="name" class="form-control" required="required" placeholder="Наименование организации" value="{{old('name')}}">
            @error('name')
            <div class="alert alert-danger">
                @foreach($errors->get('name') as $error)
                    {{ $error }}
                @endforeach
            </div>
            @enderror
        </div>
        <div class="form-group col-md-12">
            <input type="submit" name="submit" class="btn btn-primary pull-right" value="Добавить">
        </div>
    </form>







@stop



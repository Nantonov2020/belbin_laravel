@extends('layouts.admin')

@section('content')

    @isset ($department)

        <div class="text-danger">
            {{ session('success') }}
        </div>

        <h3>Смена наименования для подразделения: <a href="{{route('department',$id=$department->id)}}">{{$department->name}}</a></h3>

        <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{route('admin.updateDepartment', $id=$department->id)}}">
            @csrf
            <div class="form-group col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Скорректированное наименование" value="{{old('name')}}">
                @error('name')
                <div class="alert alert-danger">
                    @foreach($errors->get('name') as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Сменить название">
            </div>
        </form>

    @endisset

    @empty($department)
        <p>Подразделение не найдено</p>
    @endempty

@stop

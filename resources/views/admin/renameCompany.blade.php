@extends('layouts.admin')

@section('content')

    @isset ($company)

        <div class="text-danger">
            {{ session('success') }}
        </div>

        <h3>Смена наименования для компании: {{$company->name}}</h3>

        <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{route('company.update',$id=$company->id)}}">
            @method("put")
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

    @empty($company)
        <p>Компания не найдена</p>
    @endempty

@stop

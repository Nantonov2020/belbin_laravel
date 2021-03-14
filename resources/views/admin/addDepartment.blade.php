@extends('layouts.admin')

@section('content')
    <div class="text-danger">
        {{ session('success') }}
    </div>
    <h3>Добавить подразделение</h3>
    <form id="main-contact-form" class="contact-form row" name="contact-form" method="post" action="{{route('department.store')}}">
        @csrf
        <div class="form-group col-md-7">
            <input type="text" name="name" class="form-control" required="required" placeholder="Наименование подразделения" value="{{old('name')}}">
            @error('name')
            <div class="alert alert-danger">
                @foreach($errors->get('name') as $error)
                    {{ $error }}
                @endforeach
            </div>
            @enderror
        </div>

        <div class="form-group col-md-7">
            <br>
            Организация: <br>
            <select name="company_id">

                @forelse($companies as $company)

                    <option value="{{$company->id}}">{{$company->name}}</option>
                @empty
                    <option value="0">-</option>
                @endforelse

            </select>
            <br><br>
        </div>

        <div class="form-group col-md-12">
            <input type="submit" name="submit" class="btn btn-primary pull-right" value="Добавить">
        </div>
    </form>

@stop

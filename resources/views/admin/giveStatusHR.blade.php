@extends('layouts.admin')

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-danger">
                    {{ session('success') }}
                </div>
                <div class="card-header">Предоставление статуса HR для пользователя</div>

                <div class="card-body">
                    <form method="POST" action="{{route('giveStatusHRAction')}}">
                        @csrf

                        <div class="form-group row">
                            <p for="user" class="col-md-4 text-md-right">Пользователь:</p>

                            <div class="col-md-6">
                                <p id="user"><a href="{{route('user',$id=$user->id)}}">{{$user->secondName}} {{$user->firstName}} {{$user->middleName}}</a></p>
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company" class="col-md-4 col-form-label text-md-right">Организация:</label>

                            <div class="col-md-6">
                                <select name="company" id="company" class="form-control @error('company') is-invalid @enderror">
                                    <option value="0" selected>-</option>

                                    @forelse($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Присвоить статус
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop


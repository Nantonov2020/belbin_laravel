@extends('layouts.hr')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-danger">
                        {{ session('success') }}
                    </div>
                    <div class="card-header">{{ __('Добавление пользователю статуса работника') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('hr.giveStatusWorkerAction',$idCompany)}}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <div class="form-group row">
                                <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Пользователь') }}</label>

                                <div class="col-md-6">
                                    <input id="user" type="text" class="form-control" name="user" value="{{ $user->secondName }} {{ $user->firstName }} {{ $user->middleName }}" readonly>

                                    @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Подразделение') }}</label>

                                <div class="col-md-6">
                                    <select name="department" id="department" class="form-control @error('department') is-invalid @enderror">
                                        <option value="0" selected>-</option>
                                        @forelse($departments as $department)
                                            <option value="{{$department->id}}">{{$department->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="head" class="col-md-4 form-check-label text-md-right">{{ __('Руководитель') }}</label>

                                <div class="col-md-6 px-5">
                                    <input type="checkbox" name="head" class="form-check-input" id="head" value="1">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="candidate" class="col-md-4 form-check-label text-md-right">{{ __('Кандидат') }}</label>

                                <div class="col-md-6 px-5">
                                    <input type="checkbox" name="candidate" class="form-check-input" id="candidate" value="1">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Присвоить статус сотрудника') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

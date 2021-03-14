@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="text-danger">
                        {{ session('success') }}
                    </div>
                    <div class="card-header">{{ __('Добавление нового пользователя') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('addUser')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Адрес') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="secondName" class="col-md-4 col-form-label text-md-right">{{ __('Фамилия') }}</label>

                                <div class="col-md-6">
                                    <input id="secondName" type="text" class="form-control @error('secondName') is-invalid @enderror" name="secondName" value="{{ old('secondName') }}" required autocomplete="secondName">

                                    @error('secondName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>

                                <div class="col-md-6">
                                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" required autocomplete="firstName">

                                    @error('firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="middleName" class="col-md-4 col-form-label text-md-right">{{ __('Отчество') }}</label>

                                <div class="col-md-6">
                                    <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') }}" required autocomplete="middleName">

                                    @error('middleName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company" class="col-md-4 col-form-label text-md-right">{{ __('Организация') }}</label>

                                <div class="col-md-6">
                                    <select name="company" id="company" class="form-control @error('company') is-invalid @enderror">
                                        <option value="0" selected>-</option>

                                        @forelse($companies as $company)
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('company')
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
                                    </select>
                                    @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                    <label for="hr" class="col-md-4 form-check-label text-md-right">{{ __('Сотрудник HR') }}</label>

                                    <div class="col-md-6 px-5">
                                        <input type="checkbox" name="hr" class="form-check-input" id="hr" value="1">
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

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Телефон (для HR)') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone">

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Добавить') }}
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

@push('scripts')
    <script>
        window.onload = function (){
            function giveListDepartments()
            {
                if (company.value > 0)  {
                    let url = "{{route('giveSetDepartments')}}"+"?id="+company.value;
                    fetch(url)
                        .then(response => response.json())
                        .then(result => {
                            let opts = departments.options;
                            while(opts.length > 0){
                                opts[opts.length-1] = null;
                            }
                            for (let key in result){
                                departments.options[departments.options.length] = new Option(result[key], key);
                            }
                            departments.options[departments.options.length] = new Option('-', 0);
                        })
                        .catch(() => console.log('ошибка'));
                }
            }
            let company = document.getElementById('company');
            let departments = document.getElementById('department');
            company.addEventListener('change',giveListDepartments);
        }
    </script>
@endpush

@extends('layouts.user')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="text-danger">
                    {{ session('success') }}
                </div>
                <div class="card-header">Страница пользователя</div>

                <div class="card-body">

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Логин</label>

                        <div class="col-md-10">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="secondname" class="col-md-2 col-form-label text-md-right">Фамилия</label>

                        <div class="col-md-10">
                            <input id="secondname" type="text" class="form-control" name="name" value="{{ $user->secondName }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="firstname" class="col-md-2 col-form-label text-md-right">Имя</label>

                        <div class="col-md-10">
                            <input id="firstname" type="text" class="form-control" name="name" value="{{ $user->firstName }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="middlename" class="col-md-2 col-form-label text-md-right">Отчество</label>

                        <div class="col-md-10">
                            <input id="middlename" type="text" class="form-control" name="name" value="{{ $user->middleName }}" readonly>
                        </div>
                    </div>

                    @isset($workers[0])
                        <div class="form-group row">
                            <label class="col-md-10 col-form-label text-md-right"><b>Вы числитесь в следующих предприятиях:</b></label>
                        </div>
                    @endisset

                    @forelse($workers as $item)
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label text-md-right"><b>{{$item->name}}</b>
                                <br>({{$item->name_department}})

                                @if($item->is_head)
                                    (Руководитель)
                                @endif

                                @if($item->is_candidate)
                                    (Кандидат)
                                @endif

                            </label>
                        </div>
                    @empty
                        <div class="form-group row">
                            <label class="col-md-12 col-form-label text-md-right">Вы не числитесь ни в одном предприятии.</label>
                        </div>
                    @endforelse
                    <hr>
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label text-md-right">Прохождние теста</label>

                        <div class="col-md-10">
                            @if ($questionnaires->status == true)

                                <p class="text-danger">Вы прошли тест {{ $questionnaires->updated_at }}.<br>Следующая возможность пройти тест будет доступна не ранее чем {{$nextData}}</p>

                            @else
                                @if ($questionnaires->results == '{}')
                                    <a type="button" class="btn btn-primary" href="{{ route('user.start') }}">Пройти тест</a>
                                @else
                                    <a type="button" class="btn btn-primary" href="{{route('user.questionnaire')}}">Продолжить прохождение теста</a>
                                @endif

                            @endif
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>


@stop

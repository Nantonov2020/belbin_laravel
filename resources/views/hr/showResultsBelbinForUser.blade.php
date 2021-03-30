@extends('layouts.hr')

@section('content')

<h2>Результаты сдачи тестов Белбина</h2><br>
    <h3>Сотрудника: <a href="{{ route('hr.worker',$user->id) }}">{{ $user->secondName }}
        @isset($user->firstName)
            &nbsp;{{ $user->firstName }}
        @endisset
        @isset($user->middleName)
            &nbsp;{{ $user->middleName }}
        @endisset
        </a>
    </h3>

<table class="table table-striped table-bordered">
    <tr align="center">
        <td><b>№ п/п</b></td>
        <td><b>Дата сдачи теста</b></td>
        <td scope="col">
                <span title="Рабочая пчёлка (Реализатор)">
                    <b>РП</b>
                </span>
        </td>
        <td scope="col">
                <span title="Руководитель (Координатор)">
                    <b>РК</b>
                </span>
        </td>
        <td scope="col">
                <span title="Мотиватор (Творец)">
                    <b>МТ</b>
                </span>
        </td>
        <td scope="col">
                <span title="Генератор идей">
                    <b>ГИ</b>
                </span>
        </td>
        <td scope="col">
                <span title="Снабженец (Исследователь)">
                    <b>СН</b>
                </span>
        </td>
        <td scope="col">
                <span title="Эксперт">
                    <b>АН</b>
                </span>
        </td>
        <td scope="col">
                <span title="Вдохновитель (Дипломат)">
                    <b>ВД</b>
                </span>
        </td>
        <td scope="col">
                <span title="Контролёр (Исполнитель)">
                    <b>КН</b>
                </span>
        </td>
    </tr>

    @forelse($questionaries as $item)

        <tr>
            <td align="center">{{ $loop->iteration }}</td>
            <td>

                    {{ $item->updated_at }}

            </td>

            @for ($i = 0; $i < 8; $i++)
                @if ($item->resultForTable[$i]->getColorCell() == 0)
                    <td class="table-danger" align="center">
                @elseif ($item->resultForTable[$i]->getColorCell() == 2)
                    <td class="table-primary" align="center">
                @elseif ($item->resultForTable[$i]->getColorCell() == 3)
                    <td class="table-success" align="center">
                @else
                    <td align="center">
                        @endif
                        {{ $item->resultForTable[$i]->getValue() }}
                    </td>
                    @endfor
        </tr>


    @empty
        <tr>
            <td colspan="10">
                Данный сотрудник не сдавал тест.
            </td>
        </tr>
    @endforelse


</table>


@stop

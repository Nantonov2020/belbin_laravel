@extends('layouts.hr')

@section('content')

    <h2>Результаты по тестам Белбина подразделения:<br> <b>{{ $department->name }}</b></h2>

    <table class="table table-striped">
        <tr>
            <th>№ п/п</th>
            <th>Сотрудник</th>
            <th scope="col">
                <span title="Рабочая пчёлка (Реализатор)">
                    РП
                </span>
            </th>
            <th scope="col">
                <span title="Руководитель (Координатор)">
                    РК
                </span>
            </th>
            <th scope="col">
                <span title="Мотиватор (Творец)">
                    МТ
                </span>
            </th>
            <th scope="col">
                <span title="Генератор идей">
                    ГИ
                </span>
            </th>
            <th scope="col">
                <span title="Снабженец (Исследователь)">
                    СН
                </span>
            </th>
            <th scope="col">
                <span title="Эксперт">
                    АН
                </span>
            </th>
            <th scope="col">
                <span title="Вдохновитель (Дипломат)">
                    ВД
                </span>
            </th>
            <th scope="col">
                <span title="Контролёр (Исполнитель)">
                    КН
                </span>
            </th>
        </tr>

        @forelse($questionaries as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->secondName }}
                    @isset($item->firstName)
                        &nbsp;{{ $item->firstName }}
                    @endisset
                    @isset($item->middleName)
                        &nbsp;{{ $item->middleName }}
                    @endisset

                @if ($item->is_head == true)
                    <br>(Руководитель)
                @endif
                </td>

                @for ($i = 0; $i < 8; $i++)
                    <td>
                        {{ $item->resultForTable[$i] }}
                    </td>
                @endfor
            </tr>
        @empty
            <tr>
                <td colspan="10">
                    В данном подразделении нет сотрудников.
                </td>
            </tr>
        @endforelse

    </table>

@stop

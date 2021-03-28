@extends('layouts.hr')

@section('content')

    <h2>Результаты по тестам Белбина подразделения:<br> <b><a href="{{ route('hr.department', $department->id) }}">{{ $department->name }}</a></b></h2>

    @inject('data', 'App\Services\BelbinService')
    <input type="hidden" id="infoForJS" value="{{ $data->getJSONFromQuestionnairesForJS($questionaries) }}">

    <table class="table table-striped">
        <tr>
            <td>№ п/п</td>
            <td>Сотрудник</td>
            <td scope="col">
                <span title="Рабочая пчёлка (Реализатор)">
                    РП
                </span>
            </td>
            <td scope="col">
                <span title="Руководитель (Координатор)">
                    РК
                </span>
            </td>
            <td scope="col">
                <span title="Мотиватор (Творец)">
                    МТ
                </span>
            </td>
            <td scope="col">
                <span title="Генератор идей">
                    ГИ
                </span>
            </td>
            <td scope="col">
                <span title="Снабженец (Исследователь)">
                    СН
                </span>
            </td>
            <td scope="col">
                <span title="Эксперт">
                    АН
                </span>
            </td>
            <td scope="col">
                <span title="Вдохновитель (Дипломат)">
                    ВД
                </span>
            </td>
            <td scope="col">
                <span title="Контролёр (Исполнитель)">
                    КН
                </span>
            </td>
            <td rowspan="{{ (count($questionaries))+2 }}">
                <div style="width: 300px; height: 300px;">
                    <canvas id="myChart" width="100" height="100"></canvas>
                </div>
            </td>
        </tr>

        @forelse($questionaries as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('hr.worker', $item->idUser) }}">

                    {{ $item->secondName }}
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
                    @if ($item->resultForTable[$i]->getColorCell() == 0)
                        <td class="table-danger">
                    @elseif ($item->resultForTable[$i]->getColorCell() == 2)
                        <td class="table-primary">
                    @elseif ($item->resultForTable[$i]->getColorCell() == 3)
                        <td class="table-success">
                    @else
                        <td>
                    @endif
                        {{ $item->resultForTable[$i]->getValue() }}
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
        <tr>
            <td colspan="2"><b>Среднее значение по подразделению:</b></td>
            @foreach ($averageResults as $item)
                <td>
                    <b>{{ $item }}</b>
                </td>
            @endforeach

        </tr>

    </table>
@stop
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>

        let result = document.getElementById('infoForJS').value;
        console.log(result);

        let tit1 = ['РП', 'РК', 'МТ', 'ГИ', 'СН', 'АН', 'ВД', 'КН'];

        let ctx = document.getElementById('myChart').getContext('2d');
        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: tit1,
                datasets:
                    [{
                    backgroundColor: 'red',
                    borderColor: 'red',
                    data:[2,3,4,5,6,7,8,25],
                    label:'FIO1',
                    fill:false
                    }
                    ]
            },

            // Configuration options go here
            options: {
                legend: {
                    position: "right"
                }
            }
        });
    </script>
@endpush

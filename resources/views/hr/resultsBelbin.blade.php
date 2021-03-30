@extends('layouts.hr')

@section('content')

    <h2>Результаты по тестам Белбина подразделения:<br> <b><a href="{{ route('hr.department', $department->id) }}">{{ $department->name }}</a></b></h2>

    @inject('data', 'App\Services\BelbinService')
    <input type="hidden" id="infoForJS" value="{{ $data->getJSONFromQuestionnairesForJS($questionaries) }}">

    <table class="table table-striped table-bordered">
        <tr align="center">
            <td><b>№ п/п</b></td>
            <td><b>Сотрудник</b></td>
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
            <td rowspan="{{ (count($questionaries))+2 }}">
                <div style="width: 500px; height: 500px;">
                    <canvas id="myChart" width="100" height="100"></canvas>
                </div>
            </td>
        </tr>

        @forelse($questionaries as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
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
                @if ($item->is_candidate == true)
                    <br>(Кандидат)
                @endif
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
                    В данном подразделении нет сотрудников.
                </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="2"><b>Среднее значение по подразделению:</b></td>
            @foreach ($averageResults as $item)
                <td align="center">
                    <b>{{ $item }}</b>
                </td>
            @endforeach

        </tr>

    </table>
@stop
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>

        let colorsForDiagramm = ['red', 'green', 'blue', 'Gold', 'Fuchsia',
                                'MediumSpringGreen', 'DarkTurquoise', 'Olive',
                                'SaddleBrown', 'DarkSlateBlue', 'Indigo', 'DarkOrange',
                                'Crimson', 'DarkOliveGreen', 'DodgerBlue', 'Maroon',
                                'DarkSlateGray', 'DarkMagenta', 'FireBrick', 'ForestGreen'];
        let result = document.getElementById('infoForJS').value;
        let resultObj = JSON.parse(result);
        let dataForDiagramm = [];
        resultObj.forEach(function(item, key){

            dataForDiagramm.push(
                {backgroundColor: colorsForDiagramm[key],
                borderColor: colorsForDiagramm[key],
                data: item.result,
                label: item.name,
                fill:false}
            );
        });
        console.log(dataForDiagramm);

        let tit1 = ['РП', 'РК', 'МТ', 'ГИ', 'СН', 'АН', 'ВД', 'КН'];

        let ctx = document.getElementById('myChart').getContext('2d');
        let chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'radar',

            // The data for our dataset
            data: {
                labels: tit1,
                datasets:dataForDiagramm

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

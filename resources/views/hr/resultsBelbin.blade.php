@extends('layouts.hr')

@section('content')

    <h2>Результаты по тестам Белбина подразделения:<br> {{ $department->name }}</h2>

    <table>
        <tr>
            <th>№ п/п</th>
            <th>Сотрудник</th>
            <th>РП</th>
            <th>РК</th>
            <th>МТ</th>
            <th>ГИ</th>
            <th>СН</th>
            <th>АН</th>
            <th>ВД</th>
            <th>КН</th>
        </tr>

    </table>

@stop

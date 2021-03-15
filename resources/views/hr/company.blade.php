@extends('layouts.hr0')

@section('content')

    <div class="row">
        <div class="col-6"><h1>Компании</h1></div>
    </div>

    @forelse($companies as $company)
        <p class="border border-primary"><a href="{{route('hr.index', $company->id)}}"><h3>{{$company->name}}</h3></a>
        </p>
    @empty
        <h3>Компаний не найдено</h3>
    @endforelse

@stop

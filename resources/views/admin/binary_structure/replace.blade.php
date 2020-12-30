<?php
$binary_structure_ids = \App\Models\BinaryStructure::all()->pluck('name_ru', 'id')->toArray();
$structure_body = \App\Models\StructureBody::groupBy('number')->get()->pluck('number', 'number')->toArray();
$users = \App\Models\Users::where('status_id', '!=', 0)->get()->pluck('login', 'user_id')->toArray();
?>
@extends('admin.layout.layout')


@section('content')
    <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">
            <form action="{{route('binary_structure.replace')}}" method="POST">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <label for="binary_structure_id">Укажите стол</label>
                {{Form::select('binary_structure_id', $binary_structure_ids, null,
                ['class' => 'form-control'])}}
                <br>
                <label for="number">Укажите номер стола</label>
                {{Form::select('number', $structure_body, null,
               ['class' => 'form-control'])}}
                <br>
                <label for="number">Укажите номер стола</label>
                {{Form::select('users', $users, null,
               ['class' => 'form-control', 'id' => 'users'])}}

            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
    <script>
        $('#users').selectpicker();
    </script>
@endsection
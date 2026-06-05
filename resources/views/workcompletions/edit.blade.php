@extends('layouts.app')

@section('page-title', 'Edit Work Completion')

@section('content')
    @include('workcompletions._form', [
        'workcompletion' => $workcompletion,
        'allocations' => $allocations,
        'selectedAllocation' => $selectedAllocation,
        'title' => 'Edit nota terima kerja',
        'submitLabel' => 'Update Nota',
    ])
@endsection

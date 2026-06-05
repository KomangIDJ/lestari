@extends('layouts.app')

@section('page-title', 'Create Work Completion')

@section('content')
    @include('workcompletions._form', [
        'workcompletion' => null,
        'allocations' => $allocations,
        'selectedAllocation' => $selectedAllocation,
        'title' => 'Create a new nota terima kerja',
        'submitLabel' => 'Save Nota',
    ])
@endsection

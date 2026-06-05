@extends('layouts.app')

@section('page-title', 'Edit Work Allocation')

@section('content')
    @include('workallocations._form', [
        'workallocation' => $workallocation,
        'employees' => $employees,
        'products' => $products,
        'title' => 'Edit SPK ' . $workallocation->sw,
        'submitLabel' => 'Update SPK',
    ])
@endsection

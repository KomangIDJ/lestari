@extends('layouts.app')

@section('page-title', 'Create Work Allocation')

@section('content')
    @include('workallocations._form', [
        'workallocation' => null,
        'employees' => $employees,
        'products' => $products,
        'previewNumber' => $previewNumber,
        'title' => 'Create a new SPK',
        'submitLabel' => 'Save SPK',
    ])
@endsection

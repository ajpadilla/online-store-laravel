@extends('layouts.pages.page')

@section('title') Orders @stop

@section('content')
    <!--<div class="btn-toolbar">
        <button class="btn btn-primary">New User</button>
        <button class="btn">Import</button>
        <button class="btn">Export</button>
    </div>-->
    <div class="well">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Customer name</th>
                <th>Customer email</th>
                <th>Customer document number</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Product</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->custom_email }}</td>
                    <td>{{ $order->customer_document_number}}</td>
                    <td>{{$order->amount}}</td>
                    <td><a href="#" class="btn btn-primary"><i class="icon-pencil"></i>{{$order->status}}</a></td>
                    <td>Product</td>
                    <td>
                        <a href="#" class="btn btn-primary"><i class="icon-pencil"></i>Show</a>
                    </td>
                </tr>
            @empty
                <p>No orders</p>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">
        {{ $orders->links() }}
    </div>
@stop

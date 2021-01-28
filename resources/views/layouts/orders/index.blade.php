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
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
                <th style="width: 36px;"></th>
            </tr>
            </thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>
                        <a href="#" class="btn btn-primary"><i class="icon-pencil"></i>Comprar</a>
                    </td>
                </tr>
            @empty
                <p>No products</p>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <ul>
            <li><a href="#">Prev</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">Next</a></li>
        </ul>
    </div>
@stop

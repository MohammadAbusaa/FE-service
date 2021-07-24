@extends('layout')
@section('title')
    Information
@endsection
@section('content')
    <table class="table table-striped table-bordered" style="width: 50%; margin-top:50px;">
        <tbody>
            <tr>
                <th scope="row">#</th>
                <td>{{$info->id}}</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{$info->name}}</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{$info->qty}}</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{$info->price}}</td>
            </tr>
            <tr>
                @if ($info->qty>0)
                    <td colspan="2">
                        <div style="width:100px;" class="mx-auto">
                            <a href="/purchase/{{$info->id}}">
                                <button class="btn btn-outline-success">Purchase</button>
                            </a>
                        </div>
                    </td>    
                @else
                    <td class="table-danger" colspan="2" style="text-align: center">Out of stock!</td>
                @endif
                
            </tr>
        </tbody>
    </table>
@endsection
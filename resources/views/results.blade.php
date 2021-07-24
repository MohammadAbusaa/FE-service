@extends('layout')
@section('title')
    Search results
@endsection
@section('content')
<table class="table table-striped table-primary table-hover table-bordered" style="margin-top: 50px;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($results as $result)
        <tr>
            <th scope="row">{{$result->id}}</th>
            <td>{{$result->name}}</td>
            <td class="d-flex justify-content-center"><a class="btn btn-primary" href="http://localhost:8000/info/{{$result->id}}">info</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
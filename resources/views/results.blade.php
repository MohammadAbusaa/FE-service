@extends('layout')
@section('title')
    Search results
@endsection
@section('content')
  @if (is_null($results))
      <p class="text-danger">Either the search query is not correct or we couldn't connect to servers!</p>
  @else
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
            <td class="d-flex justify-content-center"><a class="btn btn-primary" href="/info/{{$result->id}}">info</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @endif
@endsection
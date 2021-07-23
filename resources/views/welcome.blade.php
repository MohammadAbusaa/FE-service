<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <table class="table table-striped">
        <tbody>
            <tr>
                <th scope="row">
                    <h1>Welcome to bazar.com! the world's smallest bookstore.</h1>
                </th>
                <td>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    Search for a book
                                </th>
                                <form action="http://localhost:8000/books/search" method="get">
                                <td>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="exampleFormControlInput1" name="bookName" placeholder="type something here">
                                      </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="method" id="flexRadioDefault1" value="type">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                              by type
                                            </label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="method" id="flexRadioDefault2" value="name" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                              by name
                                            </label>
                                          </div>
                                          <span class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                          </span>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    Available books
                    <table class="table table-striped table-primary table-hover table-bordered" style="margin-top: 50px;">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($books as $book)
                            <tr>
                                <th scope="row">{{$book->id}}</th>
                                <td>{{$book->name}}</td>
                                <td class="d-flex justify-content-center"><a class="btn btn-primary" href="http://localhost:8000/info/{{$book->id}}">info</a></td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                </th>
            </tr>
        </tbody>
    </table>
</body>
</html>
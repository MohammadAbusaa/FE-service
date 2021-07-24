<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BooksController extends Controller{
    public function index() //this function is used to get all books
    {                       //in the store and show them to the user

        $client=new \GuzzleHttp\Client([            //GuzzleHttp is a library that makes http requests handling easier
            'base_uri'=>'http://192.168.1.21:8000',
        ]);
        $response=$client->get('/books');           //send a get request, the response object is returned

        return view('welcome',['books'=>json_decode($response->getBody())]);    //return a view to the user 
    }                                                                           //with data in the response

    public function show(Request $request)      //this function is used to search for books
    {

        $data=$this->validate($request,[
            'bookName'=>'required',
            'method'=>'required',
        ]);

        $client=new Client();

        $response=$client->get('http://192.168.1.21:8000/books/search',[ //this call is the same as above
            'query'=>[                                                   //with search info 
                'bName'=>$data['bookName'],
                'sMethod'=>$data['method'],
            ],
        ]);

        return view('results',['results'=>json_decode($response->getBody())]);  //retrun a view to the user
    }                                                                           //with data in the response

    public function info($id) //this function is used to show info for a specific item
    {
        try {
            (Int)$id;
        } catch (\Throwable $th) {
            return redirect('home');
        }
        $client=new Client();

        $response=$client->get('http://192.168.1.21:8000/info/'.$id);

        return view('info_page',['info'=>json_decode($response->getBody())]);
    }

    public function purchase($id) //this function is used to send purchase requests for a specific item
    {
        $client=new Client();

        $response=$client->post('http://192.168.1.22:8000/purchase/'.$id);

        return view('status',['status'=>json_decode($response->getBody())]);
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Client;

class BooksController extends Controller{
    public function index()
    {
        $client=new \GuzzleHttp\Client([
            'base_uri'=>'http://192.168.1.21:8000',
        ]);
        // $url='http://192.168.1.21:8000/books';
        // $curl = curl_init($url);
        // //curl_setopt($curl, CURLOPT_POST, true);
        // //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($curl);
        // curl_close($curl);

        $response=$client->get('/books');

        return view('welcome',['books'=>json_decode($response->getBody())]);
    }

    public function show(Request $request)
    {

        $data=$this->validate($request,[
            'bookName'=>'required',
            'method'=>'required',
        ]);

        $client=new Client();

        $response=$client->get('http://192.168.1.21:8000/books/search',[
            'query'=>[
                'bName'=>$data['bookName'],
                'sMethod'=>$data['method'],
            ],
        ]);

        return view('results',['results'=>json_decode($response->getBody())]);
    }

    public function info($id)
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
}
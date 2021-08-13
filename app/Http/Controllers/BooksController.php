<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class BooksController extends Controller
{
    

    public function UpdateURL()
    {
        $index=Config::get('index');
        parent::$url = parent::$urls[$index];
        if ($index > 2) Config::set('index', 0);
        else Config::set('index', $index+1);
    }

    public function index() //this function is used to get all books
    {                       //in the store and show them to the user

        set_time_limit(60);
        if (Cache::has('Books')) {
            error_log('Cached!');
            return view('welcome', ['books' => Cache::get('Books')]);
        }
        $this->UpdateURL();
        $response = null;
        try {
            $client = new \GuzzleHttp\Client([            //GuzzleHttp is a library that makes http requests handling easier
                'base_uri' => parent::$url,
            ]);
            $response = $client->get('/books');           //send a get request, the response object is returned

            $data = json_decode($response->getBody());
            Cache::put('Books', $data, 60);
        } catch (ConnectException $th) {
            //return \GuzzleHttp\Psr7\Message::toString($th->getRequest());
            $this->UpdateURL();
            try {
                $response = (new \GuzzleHttp\Client())->get(parent::$url . '/books');
                $data = json_decode($response->getBody());
                Cache::put('Books', $data, 60);
            } catch (ConnectException $t) {
                $this->UpdateURL();
                try {
                    $response = (new \GuzzleHttp\Client())->get(parent::$url . '/books');
                    $data = json_decode($response->getBody());
                    Cache::put('Books', $data, 60);
                } catch (ConnectException $e) {
                    $data = null;
                } catch (\Throwable $th) {
                    //throw $th;
                    error_log($th->getMessage());
                }
            }
        }
        return view('welcome', ['books' => $data]);    //return a view to the user 
    }                                                                           //with data in the response

    public function show(Request $request)      //this function is used to search for books
    {

        $data = $this->validate($request, [
            'bookName' => 'required',
            'method' => 'required',
        ]);
        set_time_limit(60);
        $this->UpdateURL();
        try {
            $client = new Client();

            $response = $client->get(parent::$url . '/books/search', [ //this call is the same as above
                'query' => [                                                   //with search info 
                    'bName' => $data['bookName'],
                    'sMethod' => $data['method'],
                ],
            ]);
            $data = json_decode($response->getBody());
        } catch (ConnectException $th) {
            $this->UpdateURL();
            try {
                $client = new Client();

                $response = $client->get(parent::$url . '/books/search', [ //this call is the same as above
                    'query' => [                                                   //with search info 
                        'bName' => $data['bookName'],
                        'sMethod' => $data['method'],
                    ],
                ]);
                $data = json_decode($response->getBody());
            } catch (ConnectException $th) {
                $this->UpdateURL();
                try {
                    $client = new Client();

                    $response = $client->get(parent::$url . '/books/search', [ //this call is the same as above
                        'query' => [                                                   //with search info 
                            'bName' => $data['bookName'],
                            'sMethod' => $data['method'],
                        ],
                    ]);
                    $data = json_decode($response->getBody());
                } catch (ConnectException $e) {
                    $data = null;
                } catch (\Throwable $th) {
                    //throw $th;
                    error_log($th->getMessage());
                }
            }
        }

        return view('results', ['results' => $data]);  //retrun a view to the user
    }                                                                           //with data in the response

    public function info($id) //this function is used to show info for a specific item
    {
        try {
            (int)$id;
        } catch (\Throwable $th) {
            return redirect('home');
        }

        if (Cache::has('info' . $id)) {
            error_log('Cached!');
            return view('info_page', ['info' => Cache::get('info' . $id)]);
        }
        set_time_limit(60);
        $this->UpdateURL();

        try {
            $client = new Client();

            $response = $client->get(parent::$url . '/info/' . $id);

            $data = json_decode($response->getBody());

            Cache::put('info' . $id, $data, 60);
        } catch (ConnectException $th) {
            $this->UpdateURL();
            try {
                $client = new Client();

                $response = $client->get(parent::$url . '/info/' . $id);

                $data = json_decode($response->getBody());

                Cache::put('info' . $id, $data, 60);
            } catch (ConnectException $t) {
                $this->UpdateURL();
                try {
                    $client = new Client();

                    $response = $client->get(parent::$url . '/info/' . $id);

                    $data = json_decode($response->getBody());

                    Cache::put('info' . $id, $data, 60);
                } catch (ConnectException $t) {
                    $data = null;
                } catch (\Throwable $th) {
                    error_log($th->getMessage());
                }
            }
        }

        return view('info_page', ['info' => $data]);
    }

    public function purchase($id) //this function is used to send purchase requests for a specific item
    {

        $response = null;
        set_time_limit(120);
        if ($id == 1 || $id == 2) {
            try {
                $client = new Client();

                $response = $client->post('http://192.168.1.22:8000/purchase/' . $id);
            } catch (ConnectException $e) {
                error_log('server 1');
                error_log(\GuzzleHttp\Psr7\Message::toString($e->getRequest()));
            }
        } else if ($id == 3 || $id == 4) {
            try {
                $client = new Client();

                $response = $client->post('http://192.168.1.22:7999/purchase/' . $id);
            } catch (ConnectException $e) {
                error_log('server 2');
                error_log(\GuzzleHttp\Psr7\Message::toString($e->getRequest()));
            }
        } else if ($id > 4 && $id < 8) {
            try {
                $client = new Client();

                $response = $client->post('http://192.168.1.22:7998/purchase/' . $id);
            } catch (ConnectException $e) {
                error_log('server 3');
                error_log(\GuzzleHttp\Psr7\Message::toString($e->getRequest()));
            }
        }

        if (is_null($response))
            return view('status', ['status' => array(null)]);
        else
            return view('status', ['status' => json_decode($response->getBody())]);
    }
}

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
        if (Cache::get('index') > 2) {
            Cache::put('index',0);
        }
        parent::$url = parent::$urls[Cache::get('index')];        
        Cache::increment('index');
    }

    public function index() //this function is used to get all books
    {                       //in the store and show them to the user

        set_time_limit(60);
        $res=null;
        try {
            $res=json_decode((new Client())->get('192.168.1.19:7999/cache/books')->getBody());
            //foreach($res[0] as $i)error_log($i->name);
        } catch (\Throwable $th) {
            error_log('NO CACHE');
        }
        if (!is_null($res)&&!empty($res[0])) {
            error_log('Cached!');
            return view('welcome', ['books' => $res[0]]);
        }
        self::UpdateURL();
        $response = null;
        try {
            $client = new \GuzzleHttp\Client([            //GuzzleHttp is a library that makes http requests handling easier
                'base_uri' => parent::$url,
            ]);
            $response = $client->get('/books');           //send a get request, the response object is returned

            $data = json_decode($response->getBody());
            try {
                ((new Client())->post('192.168.1.19:7999/cache/books/create',['form_params'=>['books'=>$data]]));
            } catch (\Throwable $th) {
                error_log('NO CACHE TO SAVE');
            }
        } catch (ConnectException $th) {
            //return \GuzzleHttp\Psr7\Message::toString($th->getRequest());
            $this->UpdateURL();
            try {
                $response = (new \GuzzleHttp\Client())->get(parent::$url . '/books');
                $data = json_decode($response->getBody());
                try {
                    ((new Client())->post('192.168.1.19:7999/cache/books/create',['form_params'=>['books'=>$data]]));
                } catch (\Throwable $th) {
                    error_log('NO CACHE TO SAVE');
                }
            } catch (ConnectException $t) {
                $this->UpdateURL();
                try {
                    $response = (new \GuzzleHttp\Client())->get(parent::$url . '/books');
                    $data = json_decode($response->getBody());
                    try {
                        ((new Client())->post('192.168.1.19:7999/cache/books/create',['form_params'=>['books'=>$data]]));
                    } catch (\Throwable $th) {
                        error_log('NO CACHE TO SAVE');
                    }
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
        $res=null;
        try {
            $res=json_decode((new Client())->get('192.168.1.19:7999/cache/info/'.$id)->getBody());
        } catch (\Throwable $th) {
            error_log('NO CACHE');
        }
        if (!is_null($res)&&!empty($res[0])) {
            error_log('Cached!');
            return view('info_page', ['info' => $res[0]]);
        }
        set_time_limit(60);
        self::UpdateURL();

        try {
            $client = new Client();

            $response = $client->get(parent::$url . '/info/' . $id);

            $data = json_decode($response->getBody());

            try {
                (new Client())->post('192.168.1.19:7999/cache/info/create/'.$id,['form_params'=>['data'=>$data]]);
            } catch (\Throwable $th) {
                error_log('NO CACHE TO SAVE');
            }
        } catch (ConnectException $th) {
            $this->UpdateURL();
            try {
                $client = new Client();

                $response = $client->get(parent::$url . '/info/' . $id);

                $data = json_decode($response->getBody());

                try {
                    (new Client())->post('192.168.1.19:7999/cache/info/create/'.$id,['form_params'=>['data'=>$data]]);
                } catch (\Throwable $th) {
                    error_log('NO CACHE TO SAVE');
                }
            } catch (ConnectException $t) {
                $this->UpdateURL();
                try {
                    $client = new Client();

                    $response = $client->get(parent::$url . '/info/' . $id);

                    $data = json_decode($response->getBody());

                    try {
                        (new Client())->post('192.168.1.19:7999/cache/info/create/'.$id,['form_params'=>['data'=>$data]]);
                    } catch (\Throwable $th) {
                        error_log('NO CACHE TO SAVE');
                    }
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

                // $curl = curl_init();
 
                // curl_setopt_array($curl, array(
                // CURLOPT_URL => '192.168.1.22:8000/purchase/'.$id,
                // CURLOPT_RETURNTRANSFER => true,
                // CURLOPT_ENCODING => '',
                // CURLOPT_MAXREDIRS => 10,
                // CURLOPT_TIMEOUT => 0,
                // CURLOPT_FOLLOWLOCATION => true,
                // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // CURLOPT_CUSTOMREQUEST => 'POST',
                // ));
                
                // $response = curl_exec($curl);
                
                // curl_close($curl);
                $response=$client->post('192.168.1.22:8000/purchase/'.$id);
                error_log($response->getBody());
            } catch(ConnectException $e){
                error_log('xxxxxx');
                error_log(GuzzleHttp\Psr7\Message::toString($e->getResponse()));
            }
            catch (\Throwable $e1) {
                error_log(get_class($e1));
                error_log('server 1');
                error_log($e1->getMessage());
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

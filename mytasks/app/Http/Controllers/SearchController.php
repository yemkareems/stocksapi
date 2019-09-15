<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
//use App\Item;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search');
    }

    public function autocomplete(Request $request)
    {

        $client = new Client();
        $url = 'https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords='.$request['query'].'&apikey=BDKW9WX22SO2OXUL&datatype=json';
        //$url = 'https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords=aapl&apikey=BDKW9WX22SO2OXUL';

        $res = $client->request('GET', $url, []);


        if ($res->getStatusCode() == 200) { // 200 OK
            $response_data = $res->getBody()->getContents();
            //print $response_data;

            $data = json_decode(utf8_encode($response_data));
            //print_r($data->bestMatches);
            //exit;
            $data = $data->bestMatches;
//            print_r($data);
  //          exit;
            foreach ($data as $k => $datum) {

                $datum = (array)$datum;
                $data1[$k]['symbol'] = $datum['1. symbol'];
                $data1[$k]['name'] = $datum['2. name'];


            }
            $data = json_encode($data1);
        }

        //$array =


        return             $data ;
    }
}
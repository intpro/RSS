<?php

namespace Interpro\RSS\Laravel\Http;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Interpro\RSS\Concept\Command\FetchRSSCommand;

class RSSController extends Controller
{

    public function __construct()
    {

    }

    public function fetchRSS()
    {
        if(Request::has('link_name'))
        {
            $dataobj = Request::all();

            try {

                $link_name = $dataobj['link_name'];

                $this->dispatch(new FetchRSSCommand($link_name));

                return ['status' => 'OK'];

            }catch(\Exception $exception) {
                return ['status' => ('Что-то пошло не так. '.$exception->getMessage())];
            }
        } else {
            return ['status' => 'Не хватает параметров для сохранения.'];
        }
    }

}

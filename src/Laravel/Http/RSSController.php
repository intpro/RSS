<?php

namespace Interpro\RSS\Laravel\Http;

use App\Http\Controllers\Controller;
use Interpro\RSS\Concept\Command\FetchRSSCommand;

class RSSController extends Controller
{

    public function __construct()
    {

    }

    public function fetchRSS($link_name)
    {
        try {
            $this->dispatch(new FetchRSSCommand($link_name));

            return ['status' => 'OK'];

        }catch(\Exception $exception) {
            return ['status' => ($exception->getMessage())];
        }
    }

}

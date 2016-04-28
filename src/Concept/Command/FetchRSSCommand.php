<?php namespace Interpro\RSS\Concept\Command;

class FetchRSSCommand {

    public $link_name;

    /**
     * Create a new command instance.
     *
     * @param string $link_name
     *
     * @return void
     */
    public function __construct($link_name)
    {
        $this->link_name = $link_name;
    }

}

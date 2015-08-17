<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Migrations
{
    private $migrations = array();

    public function __construct()
    {
        $this->migrations[ 'forms' ]   = new NF_Database_Migrations_Forms();
        $this->migrations[ 'fields' ]  = new NF_Database_Migrations_Fields();
        $this->migrations[ 'actions' ] = new NF_Database_Migrations_Actions();
    }

    public function migrate()
    {
        foreach( $this->migrations as $migration ){
            $migration->_run();
        }
    }

}
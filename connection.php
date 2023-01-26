<?php
class Database {
    private $host;
    private $username;
    private $password;
    private $database;
    private $port;
    private $connection;

    public function __construct( $host, $username, $password, $database, $port ) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    public function connect() {
        try {
            $this->connection = new mysqli( $this->host, $this->username, $this->password, $this->database, $this->port );
            $this->connection->set_charset( 'utf8' );
            $this->connection->query( 'SET NAMES utf8' );
            $this->connection->query( "SET time_zone = '+00:00'" );
            $this->connection->query( 'SET character_set_connection = utf8' );
            $this->connection->query( 'SET character_set_results = utf8' );
            $this->connection->query( 'SET character_set_server = utf8' );
            $this->connection->query( 'SET character_set_connection = utf8' );
            $this->connection->query( 'SET character_set_results = utf8' );

            if ( $this->connection->connect_error ) {
                throw new Exception( 'Connection failed: '. $this->connection->connect_error );
            }
            return $this->connection;

        } catch( Exception $e ) {
            throw new Exception( 'Connection failed: '.$e->getMessage() );
        }
        finally {
            if ( isset( $this->connection ) ) {
                $l=1;
                #$this->connection->close();
            }
        }
    }
    public function close(){
        $this->connection->close();
    }
};
?>
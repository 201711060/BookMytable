<?php

	class dbo {

		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $dbnm = "table_booking";

		private $link;

		function __construct() {

			$this->link = mysqli_connect( $this->host, $this->user, $this->pass, $this->dbnm ) or die( mysqli_connect_error() );

		}

		function dml($q) {

			mysqli_query($this->link, $q) or die( mysqli_error($this->link) );

		}

		function get($q) {

			$res = mysqli_query($this->link, $q) or die( mysqli_error($this->link) );
			return $res;

		}


	}

	$db = new dbo();

?>
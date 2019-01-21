<?php
	Defined("BASE_PATH") or die(ACCESS_DENIED);
	
	/**
	 * Class Database
	 * Library untuk akses koneksi ke database
	 * Koneksi menggunakan PDO
	 */
	class Database{

		/**
		 * Method openConnection
		 * Proses membuka koneksi ke database
		 * @return connection {object}
		 */
		public function openConnection(){
			$dbHost = DB_HOST;
			$dbName = DB_NAME;
			try{
				$connection = new PDO("mysql:host=$dbHost;dbname=$dbName", DB_USERNAME, DB_PASSWORD);
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				return $connection;
			}
			catch(PDOException $e){
				// jika ada error
				die(json_encode(array(
					'success' => false,
					'message' => 'Fail Connection to Database',
					'error' => $e->getMessage()
				)));
			}
		}

		/**
		 * Method closeConnection
		 * Proses menutup koneksi dari database
		 * @param connection {object}
		 */
		public function closeConnection($connection){
			$connection = null;
		}
	}
<?php
    Defined("BASE_PATH") or die(ACCESS_DENIED);

    /**
	 * Class Status_orderModel
	 */
    class Status_orderModel extends Database 
    {

		private $connection;
        
		/**
		 * Method __construct
		 * Open connection to DB
		 */
		public function __construct() {
			$this->connection = $this->openConnection();
		}
		
		/**
		 * Method getAll
		 * Proses get semua data lookup order status
		 * @return result {array}
		 */
		public function getAll() {
			$query = "SELECT * FROM order_status_lookup";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
        }
        
		/**
		 * Method getById
		 * Proses get data lookup order status berdasarkan id
		 * @param id {string}
		 * @return result {array}
		 */
		public function getById($id) {
			$query = "SELECT * FROM order_status_lookup WHERE id = :id;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}
		
        /**
         * Method getByName
		 * Proses get data lookup order berdasarkan name
		 * @param name {string}
		 * @return result {array}
         */
        public function getByName($name) {
            $query = "SELECT * FROM order_status_lookup WHERE name = :name;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':name', $name);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
        }
        
		/**
		 * Method __destruct
		 * Close connection to DB
		 */
		public function __destruct() {
			$this->closeConnection($this->connection);
		}
	}
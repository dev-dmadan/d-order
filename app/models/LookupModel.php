<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
	/**
	 * Class LookupModel
	 */
    class LookupModel extends Database 
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
         * 
         */
        public function getAll_activeStatus() {
            $query = "SELECT id, name FROM active_status_lookup";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
        }

        /**
         * 
         */
        public function getAll_orderStatus() {
            $query = "SELECT id, name FROM order_status_lookup";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
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
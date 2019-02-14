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
		public function getByName_activeStatus($status) {
			$query = "SELECT id, name FROM active_status_lookup WHERE name = :name";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':name' => $status
				)
			);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
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
		 * 
		 */
		public function getByName_orderStatus($status) {
			$query = "SELECT id, name FROM order_status_lookup WHERE name = :name";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':name' => $status
				)
			);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * 
		 */
		public function getAll_level() {
			$query = "SELECT id, name FROM level_lookup";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * 
		 */
		public function getByName_level($level) {
			$query = "SELECT id, name FROM level_lookup WHERE name = :name";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':name' => $level
				)
			);
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
<?php
    Defined("BASE_PATH") or die(ACCESS_DENIED);

    /**
	 * Class Access_rightModel
	 */
    class Access_rightModel extends Database 
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
		 * Method getAll_menu
		 * Proses get semua menu yang tersedia di sistem
		 * @return result {array}
		 */
		public function getAll_menu() {
			$query = "SELECT name, url, icon FROM menu ORDER BY position ASC";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
        }
		
		/**
		 * 
		 */
		public function getAll_menuByLevel($level) {
			$query = "SELECT * FROM v_access_menu WHERE level_id = :level";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':level' => $level
				)
			);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method getAll_menuPermission
		 * Proses get semua menu permission yang tersedia  di sistem
		 * @return result {array}
		 */
		public function getAll_menuPermission() {
			$query = "SELECT * FROM v_menu_permission";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
        }
		
		/**
		 * Method getAll_rolePermission
		 * Proses get semua role permission di sistem
		 * @return result {array}
		 */
		public function getAll_rolePermission() {
			$query = "SELECT * FROM v_role_permission";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}
		
		/**
		 * 
		 */
		public function getPermissionByUser($user) {
			$query = "SELECT * FROM v_role_permission WHERE username = :username";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':username' => $user
				)
			);
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
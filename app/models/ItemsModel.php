<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
	/**
	 * Class ItemsModel
	 */
	class ItemsModel extends Database {

		private $connection;
        
		/**
		 * Method __construct
		 * Open connection to DB
		 */
		public function __construct(){
			$this->connection = $this->openConnection();
		}
		
		/**
		 * Method getAll
		 * Proses get semua data menu
		 * @return result {array}
		 */
		public function getAll(){
			$query = "SELECT * FROM v_items";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}
		/**
		 * Method getById
		 * Proses get data menu berdasarkan id
		 * @param id {string}
		 * @return result {array}
		 */
		public function getById($id){
			$query = "SELECT * FROM v_items WHERE id = :id;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}
		/**
		 * Method insert
		 * Proses insert data menu
		 * @param data {array}
		 * @return result {array}
		 */
		public function insert($data){
			$query = "CALL add_menu ();";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$result = $statement->execute(
					array(
						
					)
				);
				$statement->closeCursor();
				$this->connection->commit();
				return array(
					'success' => true,
					'error' => null
				);
			}
			catch(PDOException $e){
				$this->connection->rollback();
				return array(
					'success' => false,
					'error' => $e->getMessage()
				);
			}
        }
        
		/**
		 * Method update
		 * Proses update data menu
		 * @param data {array}
		 * @return result {array}
		 */
		public function update($data){
			$query = "CALL update_menu ();";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
      
					)
				);
				$statement->closeCursor();
				$this->connection->commit();
				return array(
					'success' => true,
					'error' => null
				);
			}
			catch(PDOException $e){
				$this->connection->rollback();
				return array(
					'success' => false,
					'error' => $e->getMessage()
				);
			}
		}
		/**
		 * Method delete
		 * Proses penghapusan data menu beserta data yang berelasi denganya
		 * @param id {string}
		 * @return result {array}
		 */
		public function delete($id){
			$query = "CALL delete_menu (:id);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
						':id' => $id
					)
				);
				$statement->closeCursor();				
				$this->connection->commit();
				return array(
					'success' => true,
					'error' => null
				);
			}
			catch(PDOException $e){
				$this->connection->rollback();
				return array(
					'success' => false,
					'error' => $e->getMessage()
				);
			}
		}
		
		/**
		 * Method __destruct
		 * Close connection to DB
		 */
		public function __destruct(){
			$this->closeConnection($this->connection);
		}
	}
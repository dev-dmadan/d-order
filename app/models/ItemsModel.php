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
		 * Proses insert data menu items
		 * @param data {array}
		 * @return result {array}
		 */
		public function insert($data){
			$query = "CALL p_add_item (:name, :price, :description, :image, :status, :created_by);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$result = $statement->execute(
					array(
						':name' => $data['name'], 
						':price' => $data['price'], 
						':description' => $data['description'], 
						':image' => $data['image'], 
						':status' => $data['status'], 
						':created_by' => $data['created_by']
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
			$query = "CALL p_edit_item (:id, :name, :price, :description, :status, :modified_by);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
						':id' => $data['id'], 
						':name' => $data['name'],
						':price' => $data['price'],
						':description' => $data['description'],
						':status' => $data['status'],
						':modified_by' => $data['modified_by']
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
		 * Proses penghapusan data menu items beserta data yang berelasi denganya
		 * @param id {string}
		 * @return result {array}
		 */
		public function delete($id){
			$query = "CALL p_delete_item (:id);";
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
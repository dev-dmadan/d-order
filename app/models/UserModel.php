<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
	/**
	 * Class UserModel
	 */
	class UserModel extends Database {

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
		 * Proses get semua data user
		 * @return result {array}
		 */
		public function getAll(){
			$query = "SELECT * FROM v_user";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method getById
		 * Proses get data user berdasarkan id
		 * @param id {string}
		 * @return result {array}
		 */
		public function getById($id){
			$query = "SELECT * FROM v_user WHERE BINARY username = :id;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method insert
		 * Proses insert data user
		 * @param data {array}
		 * @return result {array}
		 */
		public function insert($data){
			$query = "CALL p_add_user (:username, :password, :name, :level, :status, :image, :created_by);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$result = $statement->execute(
					array(
						':username' => $data['username'],
                        ':password' => $data['password'],
                        ':name' => $data['name'],
                        ':level' => $data['level'],
						':status' => $data['status'],
						':image' => $data['image'],
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
		 * Proses update data user
		 * @param data {array}
		 * @return result {array}
		 */
		public function update($data){
			$query = "CALL p_update_user (:username, :name, :modified_by);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
						':username' => $data['username'],
                        ':name' => $data['name'],
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
		 * 
		 */
		public function update_status($data) {
			$query = "UPDATE user SET status = :status, modified_by = :modified_by WHERE BINARY username = :username;";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
                        ':username' => $data['username'],
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
		 * Proses penghapusan data user beserta data yang berelasi denganya
		 * @param id {string}
		 * @return result {array}
		 */
		public function delete($id){
			$query = "CALL delete_user (:id);";
			try{
				$this->koneksi->beginTransaction();
				$statement = $this->koneksi->prepare($query);
				$statement->execute(
					array(
						':id' => $id
					)
				);
				$statement->closeCursor();				
				$this->koneksi->commit();
				return array(
					'success' => true,
					'error' => null
				);
			}
			catch(PDOException $e){
				$this->koneksi->rollback();
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
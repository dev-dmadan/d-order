<?php
    
    Defined("BASE_PATH") or die(ACCESS_DENIED);
    
	/**
	 * Class OrdersModel
	 */
	class OrdersModel extends Database 
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
		 * Proses get semua data orders
		 * @return result {array}
		 */
		public function getAll() {
			$query = "SELECT * FROM v_orders";
			$statement = $this->connection->prepare($query);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method getById
		 * Proses get data orders berdasarkan id order (order_number)
		 * @param id {string}
		 * @return result {array}
		 */
		public function getById($id) {
			$query = "SELECT * FROM v_orders WHERE order_number = :id;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method getByUser
		 * Proses get data orders berdasarkan username
		 * @param user {string}
		 * @return result {array}
		 */
		public function getByUser($user) {
			$query = "SELECT * FROM v_orders WHERE BINARY username = :user;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':user', $user);
			$statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method getDetailById
		 * Proses get data order detail berdasarkan order number
		 * @param id {string} order number
		 * @return result {array}
		 */
		public function getDetailById($id) {
			$query = "SELECT * FROM v_order_detail WHERE order_number = :id;";
			$statement = $this->connection->prepare($query);
			$statement->bindParam(':id', $id);
			$statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            
			return $result;
		}

		/**
		 * Method insert
		 * Proses insert data orders beserta detailnya
		 * @param data {array}
		 * 		dataOrder {array}
		 * 		dataDetail {array}
		 * @return result {array}
		 * 		success {boolean}
		 * 		error {string}
		 */
		public function insert($data) {
			$dataOrder = $data['dataOrder'];
			$dataDetail = $data['dataDetail'];

			try {
				$this->connection->beginTransaction();
				$this->insert_order($dataOrder);
				foreach($dataDetail as $index => $row) {
					if(!$dataDetail[$index]['delete']) {
						array_map('strtoupper', $row);
						$this->insert_detailOrder($row);
					}
				}
				$this->connection->commit();
				return array(
					'success' => true,
					'error' => null
				);
			}
			catch(PDOException $e) {
				$this->connection->rollback();
				return array(
					'success' => false,
					'error' => $e->getMessage()
				);
			}
        }
		
		/**
		 * Method insert_order
		 * Proses insert data orders
		 * @param data {array}
		 */
		private function insert_order($data) {
			$query = "CALL p_add_order (:id, :date, :money, :total, :change_money, :notes, :status, :user);";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':id' => $data['id'],
					':date' => $data['date'],
					':money' => $data['money'],
					':notes' => $data['notes'],
					':change_money' => $data['change_money'],
					':total' => $data['total'],
					':status' => $data['status'],
					':user' => $data['user']
				)
			);
			$statement->closeCursor();
		}

		/**
		 * 
		 */
		private function insert_detailOrder($data) {
			$item = ($data['item'] == '0') ? NULL : $data['item'];
			$query = "CALL p_add_order_detail (:order_id, :item, :order_item, :price_item, :qty, :subtotal, :created_by);";
			$statement = $this->connection->prepare($query);
			$statement->execute(
				array(
					':order_id' => $data['order_id'],
					':item' => $item,
					':order_item' => $data['order_item'],
					':price_item' => $data['price'],
					':qty' => $data['qty'],
					':subtotal' => $data['subtotal'],
					':created_by' => $_SESSION['sess_id']
				)
			);
			$statement->closeCursor();
		}

		/**
		 * Method update
		 * Proses update data order
		 * @param data {array}
		 * @return result {array}
		 */
		public function update($data){
			$query = "CALL p_edit_order (:id, :date, :money, :total, :change_money, :notes, :status, :modified_by);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
						':id' => $data['id'],
						':date' => $data['date'],
						':money' => $data['money'],
						':total' => $data['notes'],
						':change_money' => $data['change_money'],
						':notes' => $data['notes'],
						':status' => $data['status_id'],
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
		private function update_detailOrder($data) {

		}

		/**
		 * 
		 */
		public function update_status($data) {
			$query = "UPDATE orders SET status = :status, modified_by = :modified_by WHERE id = :id;";
			try{
				$this->connection->beginTransaction();
				$statement = $this->connection->prepare($query);
				$statement->execute(
					array(
						':id' => $data['id'],
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
		 * 
		 */
		private function delete_detailOrder() {
			
		}

		/**
		 * Method delete
		 * Proses penghapusan data order beserta data yang berelasi denganya
		 * @param id {string}
		 * @return result {array}
		 */
		public function delete($id){
			$query = "CALL delete_order (:id);";
			try{
				$this->connection->beginTransaction();
				$statement = $this->koneksi->prepare($query);
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
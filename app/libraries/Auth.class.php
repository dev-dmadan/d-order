<?php
	Defined("BASE_PATH") or die(ACCESS_DENIED);
	
	/**
	 * Class Auth
	 * Library untuk pengecekan Authentikasi yg masuk sistem
	 */
	class Auth {
		
		private $login;
		private $lockscreen;

		/**
		 * Method checkAuth
		 * Proses pengecekan status user sudah login atau belum
		 * Jika belum login maka akan diarahkan ke login
         * @param level {string}
		 */
		public function checkAuth() {
			if(!$this->isLogin()){
				$this->lockscreen = isset($_SESSION['sess_lockscreen']) ? $_SESSION['sess_lockscreen'] : false;

				// cek lockscreen
				if($this->lockscreen) {
					$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					header('Location: '.BASE_URL.'login/lockscreen/?callback='.$actual_link);
					die();
				}
				else{
					session_unset();
					session_destroy();
					header('Location: '.BASE_URL.'login');
					die();
				}
			}

			$cekTimeout = isset($_POST['timeout']) ? $_POST['timeout'] : false;

            if(!$cekTimeout) { $_SESSION['sess_timeout'] = date('Y-m-d H:i:s', time()+(60*60)); }
		}

		/**
		 * Method isLogin
		 * Proses pengecekan status login
		 */
		public function isLogin() {
			$this->login = isset($_SESSION['sess_login']) ? $_SESSION['sess_login'] : false;
			$this->timeout = isset($_SESSION['sess_timeout']) ? strtotime($_SESSION['sess_timeout']) : false;

			if(!$this->login) { return false; }
			
			if($this->login && $this->login === true && (time() > $this->timeout)) {
				$_SESSION['sess_login'] = false;
				$_SESSION['sess_lockscreen'] = true;
				return false;
			}

			return true;
        }
	}
<?php
    Defined("BASE_PATH") or die(ACCESS_DENIED);

    /**
     * Class Route
     * Proses mengarahkan semua request dari user ke controller yang dituju
     */
    class Route
    {
        
        private $__request;
        private $__controller;

        /**
         * Method setUri
         * Proses set properti __request dengan request yang diisi oleh user
         * @param request {string}
         * @return this {function} method chaining
         */
        public function setUri($request) {
            $this->__request = $request;
            return $this;
        }

        /**
         * Method getController
         * Proses load controller sesuai dengan request yang sudah di set
         */
        public function getController() {
            $uri = explode('/', $this->__request);
			$class = isset($uri[0]) && ($uri[0] != "") ? strtolower($uri[0]) : DEFAULT_CONTROLLER; // class
			$method = isset($uri[1]) ? strtolower($uri[1]) : 'index';	// method
			$param = isset($uri[2]) ? strtolower($uri[2]) : false;	// param

			// explode request untuk url cantik
			$class = str_replace('_', ' ', $class);
			$method = str_replace('_', ' ', $method);

			$tempClass = explode('-', $class);
			$tempMethod = explode('-', $method);

			$newClass = ucfirst(implode('_', $tempClass));
			$newMethod = implode('_', $tempMethod);

			// set request controller - class
			$this->__controller = ROOT.DS.'app'.DS.'controllers'.DS.$newClass."Controller.php";

			// cek file controller
			if(file_exists($this->__controller)){
				// load controller dan class
				require_once $this->__controller;
				$obj = new $newClass();

				if(method_exists($obj, $newMethod)){
                    // check method public atau tidak
                    $reflection = new ReflectionMethod($obj, $newMethod);
                    if (!$reflection->isPublic()) {
                        die($this->error('403')); // method dilarang diakses
                    }
                    else { $obj->$newMethod($param); }
				}
				else die($this->error('403')); // method tidak tersedia	
			}
			else die($this->error('404')); // class tidak tersedia
        }

        /**
         * Method error
         * Proses handling error saat request gagal atau salah
         * @param error {string}
         */
        private function error($error) {
            switch ($error) {
				case '403':
					$message = "ACCESS DENIED !";
					break;
				
				case '404':
					$message = "PAGE NOT FOUND !";
					break;

				default:
					die(ACCESS_DENIED);
					break;
			}
			
			require_once ROOT.DS.'app'.DS.'views'.DS.'auth'.DS.$error.'.php';
        }

    }
    
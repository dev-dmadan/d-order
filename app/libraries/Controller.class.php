<?php
	Defined("BASE_PATH") or die(ACCESS_DENIED);
	
	/**
	 * Class Controller
	 * Library yang berperan sebagai Parent Class untuk setiap Controller
	 */
	class Controller
	{

		/**
		 * Method model
		 * Proses load model tertentu
		 * @param modelName {string} model yang ingin di load
		 */
		final protected function model($modelName) {
			require_once ROOT.DS.'app'.DS.'models'.DS.ucfirst($modelName).'.php';
			$class = ucfirst($modelName);
			$this->$modelName = new $class();
		}

		/**
		 * Method auth
		 * Proses load library Auth.class.php
		 * @param auth {string} set default 'auth'
		 */
		final protected function auth($auth = 'auth') {
			$this->$auth = new Auth();
		}

		/**
		 * Method page
		 * Proses untuk load library Page.class.php
		 */
		final protected function page() {
			$view = new Page();
			return $view;
		}

		/**
		 * Method excel
		 * Proses untuk load library Excel.class.php
		 * @param excel {string} default excel
		 */
		final protected function excel($excel = 'excel') {					
			$this->$excel = new Excel();
		}

		/**
		 * Method helper
		 * Proses load library Helper.class.php
		 * @param helper {string} set default 'helper'
		 */
		final protected function helper($helper = 'helper') {
			$this->$helper = new Helper();
		}

		/**
		 * Method validation
		 * Proses load library Validation.class.php
         * @param validation {string} set default 'validation'
		 */
		final protected function validation($validation = 'validation') {
			$this->$validation = new Validation();
		}

		/**
		 * Method layout
		 * Proses untuk templating layout content, css, js, dan data
		 * @param content {string} halaman/content yang ingin dipasang di template layout. contoh: list, test/list
		 * @param config {array} default berupa null, jika diisi harus berupa array
		 * 		$config = array(
		 * 			'title' => {string}
		 * 			'property' => array(
		 * 				'main' => {string},
		 * 				'sub' => {string}
		 * 			),
		 * 			'css' => array(),
		 * 			'js' => array()
		 * 		)
		 * @param data {array} default null, data yang ingin diparsing ke layout
		 */
		final protected function layout($content, $config = null, $data = null) {
			$view = $this->page();

			// set data
			if($data != null) { $view->setData($data); }

			// set config
			if($config != null) {
				// set title page
				$view->setTitle($config['title']);

				// set property page
				$view->setProperty($config['property']);

				// set css
				foreach($config['css'] as $item) {
					$view->addCSS($item);
				}

				// set js
				foreach($config['js'] as $item) {
					$view->addJS($item);
				}
			}

			// set content
			$view->setContent($content);

			// get layout
			$view->render();
		}

		/**
		 * Method view
		 * Proses render view/page secara langsung tanpa layouting
		 * Support mengakses beberapa sub folder
		 * @param view {string}
		 */
		final protected function view($view, $data = null) {
			$viewExplode = explode('/', $view);
			
			$newView = '';
			for($i=0; $i<count($viewExplode); $i++) {
				if((count($viewExplode)-$i!=1)) $newView .= $viewExplode[$i].DS;
				else $newView .= $viewExplode[$i];
			}
			
			require_once ROOT.DS.'app'.DS.'views'.DS.$newView.'.php';
			die();
		}

		/**
		 * Method redirect
		 * Proses redirect ke halaman tertentu
		 * @param url {string} default BASE_URL
		 */
		final public function redirect($url = BASE_URL) {
			header("Location: ".$url);
			die();
		}
	}
<?php
	Defined("BASE_PATH") or die(ACCESS_DENIED);
	
	/**
	 * Class Controller
	 * Library yang berperan sebagai Parent Class untuk setiap Controller
	 */
	class Controller{

		/**
		 * Method model
		 * Proses load model tertentu
		 * @param modelName {string} model yang ingin di load
		 */
		final protected function model($modelName){
			require_once ROOT.DS.'app'.DS.'models'.DS.ucfirst($modelName).'.php';
			$class = ucfirst($modelName);
			$this->$modelName = new $class();
		}

		/**
		 * Method auth
		 * Proses load library Auth.class.php
		 * @param auth {string} set default 'auth'
		 */
		final protected function auth($auth = 'auth'){
			$this->$auth = new Auth();
		}

		/**
		 * Method helper
		 * Proses load library Helper.class.php
		 * @param helper {string} set default 'helper'
		 */
		final protected function helper($helper = 'helper'){
			$this->$helper = new Helper();
		}

		/**
		 * Method validation
		 * Proses load library Validation.class.php
         * @param validation {string} set default 'validation'
		 */
		final protected function validation($validation = 'validation'){
			$this->$validation = new Validation();
		}

		/**
		 * Method view
		 * Proses render view/page secara langsung tanpa layouting
		 * Support mengakses beberapa sub folder
		 * @param view {string}
		 */
		final protected function view($view){
			$temp = explode('/', $view);
			
			$newView = '';
			for($i=0; $i<count($temp); $i++){
				if((count($temp)-$i!=1)) $newView .= $temp[$i].DS;
				else $newView .= $temp[$i];
			}
			
			require_once ROOT.DS.'app'.DS.'views'.DS.$newView.'.php';
			die();
		}

		/**
		 * Method redirect
		 * Proses redirect ke halaman tertentu
		 * @param url {string} default BASE_URL
		 */
		final public function redirect($url = BASE_URL){
			header("Location: ".$url);
			die();
		}
	}
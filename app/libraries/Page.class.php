<?php
    Defined("BASE_PATH") or die(ACCESS_DENIED);

    /**
     * Class Page
     * Proses untuk layouting header, sidebar, content dan footer
     * Menambah CSS, JS, Title, Content, dan set Data secara dinamis
     */
    class Page
    {

        private $title;
        private $propertyPage = array();
        private $header;
        private $sidebar;
        private $content;
        private $footer;
        private $css = array();
        private $js = array();
        private $data;

        /**
         * Method setTitle
         * Proses set title html
         * @param title {string}
         */
        public function setTitle($title) {
            $this->title = $title;
        }

        /**
         * Method setProperty
         * Proses set main title dan sub title di suatu page
         * @param property {array}
         */
        public function setProperty($property) {
            $this->propertyPage['main'] = $property['main'];
            $this->propertyPage['sub'] = $property['sub'];
        }

        /**
         * Method setHeader
         * Proses set header html
         */
        public function setHeader() {
            ob_start();
            require_once ROOT.DS.'app'.DS.'views'.DS.'layout'.DS.'header.php';
            $this->header = ob_get_clean();
        }

        /**
         * Method setSidebar
         * Proses set sidebar html
         */
        public function setSidebar() {
            ob_start();
			require_once ROOT.DS.'app'.DS.'views'.DS.'layout'.DS.'sidebar.php';
			$this->sidebar = ob_get_clean();
        }

        /**
         * 
         */
        public function getSidebar() {
            $sess_menu = isset($_SESSION['sess_menu']) ? $_SESSION['sess_menu'] : false;

            if($sess_menu) {
                echo '<ul class="navbar-nav">';
                foreach($sess_menu as $menu) {
                    echo '<li class="nav-item">';
                    echo '<a href="'.BASE_URL.$menu['url'].'" class="nav-link"><i class="'.$menu['icon'].'"></i><span>'.$menu['name'].'</span></a>';
                    echo '</li>';
                }
                echo '</ul>';
            }  
        }

        /**
         * Method setContent
         * Proses set content html
         * @param content {string}
         */
        public function setContent($content) {
            $contentExplode = explode('/', $content);
			
			$newContent = '';
			for($i=0; $i<count($contentExplode); $i++) {
				if((count($contentExplode)-$i!=1)) { $newContent .= $contentExplode[$i].DS; }
				else { $newContent .= $contentExplode[$i]; }
			}

			ob_start();
			require_once ROOT.DS.'app'.DS.'views'.DS.$newContent.'.php';
			$this->content = ob_get_clean();
        }

        /**
         * Method setData
         * Proses set data ke content html
         * @param data {array}
         */
        public function setData($data) {
            $this->data = $data;
        }

        /**
         * Method setFooter
         * Proses set footer html
         */
        public function setFooter() {
            ob_start();
			require_once ROOT.DS.'app'.DS.'views'.DS.'layout'.DS.'footer.php';
			$this->footer = ob_get_clean();
        }

        /**
         * Method addCSS
         * Proses menambah css custom ke layout
         * @param path {string}
         */
        public function addCSS($path) {
            $this->css[] = $path;
        }

        /**
         * Method addJS
         * Proses menambah js custom ke layout
         * @param path {string}
         */
        public function addJS($path) {
            $this->js[] = $path;
        }

        /**
         * Method getCSS
         * Proses cetak css custom ke layout yang sudah ditambah 
         */
        public function getCSS() {
            foreach($this->css as $item) {
                echo '<link rel="stylesheet" href="'.BASE_URL.$item.'">'."\n";
            }
        }

        /**
         * Method getJS
         * Proses cetak js custom ke layout yang sudah ditambah
         */
        public function getJS() {
            foreach($this->js as $item) {
                echo '<script src="'.BASE_URL.$item.'"></script>'."\n";
            }
        }

        /**
         * Method render
         * Proses rendering / penyatuan header, sidebar, content, footer, dan data menjadi 1 page secara utuh
         */
        public function render() {
            $this->setHeader();
            $this->setSidebar();
            $this->setFooter();
            require_once ROOT.DS.'app'.DS.'views'.DS.'layout.php';
        }

    }
<?php
/**
 * Controller class file.
 *
 * Parent controller.
 *
 * @author Dmitry Avseyenko <polsad@gmail.com>
 * @link http://weegbo.com/
 * @copyright Copyright &copy; 2008-2012 Inspirativ
 * @license http://weegbo.com/license/
 * @package system.base
 * @since 0.8
 */
abstract class Controller {

    public function __construct() {
        
    }

    /**
     * Return value from Registry by name
     *
     * @access public
     * @param string $var object's name in Registry
     * @return mixed
     */
    public function __get($var) {
        return Registry::get($var);
    }

    /**
     * Called controller's method 
     *
     * @access public
     * @return void
     */
    public final function execute($action) {
        /**
         * Check action
         */
        if (!method_exists($this, $action)) {
            if (Config::get('app/router')) {
                $this->displayPage('errors/error-404.tpl', 404);
            }
            else {
                $action = 'index';
            }
        }
        $this->$action();
    }

    /**
     * Display page.
     *
     * @access public
     * @param string $page template name
     * @return void
     */
    public final function displayPage($page, $code = null, $expire = null) {
        if ($code !== null) {
            Base::sendHttpCode($code);
        }
        $this->view->display($page, $expire);
        /**
         * If statistic enable, and page is render, show statistic
         */
        if (Config::get('profiler/level')) {
            Profiler::showResult();
        }
        exit();
    }

    /**
     * Redirect on URL.
     *
     * @access public
     * @param string $page URL ('/' -  main page)
     * @return void
     */
    public final function redirect($url, $code = null) {
        if ($code !== null) {
            Base::sendHttpCode($code);
        }
        if (!preg_match('#^(https?|ftp)://#', $url)) {
            $url = Config::get('path/host').ltrim($url, '/');
        }
        Header('Location: '.$url);
        exit();
    }

    /**
     * Abstract method index.
     */
    abstract protected function index();
}
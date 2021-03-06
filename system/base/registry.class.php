<?php
/**
 * Registry class file.
 *
 * @author Dmitry Avseyenko <polsad@gmail.com>
 * @link http://weegbo.com/
 * @copyright Copyright &copy; 2008-2012 Inspirativ
 * @license http://weegbo.com/license/
 * @package system.base
 * @since 0.8
 */
class Registry {
    /**
     * @var static array for objects
     */
    private static $_store = array();

    /**
     *
     * @var static property to hold singleton instance
     */
    private static $_instance = null;

    public function __constuct() {
        
    }

    /**
     * Factory method to return the singleton instance
     *
     * @access public
     * @return Registry
     */
    public function getInstance() {
        if (null === Registry::$_instance) {
            Registry::$_instance = new Registry;
        }
        return Registry::$_instance;
    }

    /**
     * Save object in store
     *
     * @access public
     * @param string $name object's name
     * @param mixed $value object's value
     * @return bool
     */
    public static function set($name, $value) {
        if (self::isValid($name)) {
            throw new CException("Name '{$name}' used yet.", 500);
        }
        else {
            self::$_store[$name] = $value;
        }
        return true;
    }

    /**
     * If object exists in store, then return object's value, else return null
     *
     * @access public
     * @param string $name object's name
     * @return void
     */
    public static function get($name) {
        return (!self::isValid($name)) ? null : self::$_store[$name];
    }

    /**
     * Delete object from store
     *
     * @param sting $name object's name
     * @return bool
     */
    public static function delete($name) {
        $result = false;
        if (self::isValid($name)) {
            unset(self::$_store[$name]);
            $result = true;
        }
        return $result;
    }

    /**
     * Check $name in store
     *
     * @param sting $name object's name
     * @return bool
     */
    public static function isValid($name) {
        return array_key_exists($name, self::$_store);
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 扩展核心 - 加载器
 */
class MY_Loader extends CI_Loader {

    /**
	 * List of loaded sercices
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_services = array();

	/**
	 * List of paths to load sercices from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_service_paths = array(APPPATH);

    public function __construct(){
        parent::__construct();
    }

	/**
	 * Service Loader
	 *
	 * Loads and instantiates Service.
	 *
	 * @param	string	$service	Service name
	 * @param	string	$name		An optional object name to assign to
	 * @param	array	$params		Optional parameters to pass to the library class constructor
	 * @return	object
	 */
	public function service($service, $name = '', $params = NULL)
	{
		if (empty($service))
		{
			return $this;
		}
		elseif (is_array($service))
		{
			foreach ($service as $key => $value)
			{
				is_int($key) ? $this->service($value, '', $params) : $this->service($key, $value, $params);
			}

			return $this;
		}

		$path = '';

		// Is the service in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($service, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($service, 0, ++$last_slash);

			// And the service name behind it
			$service = substr($service, $last_slash);
		}

		if (empty($name))
		{
			$name = $service;
		}

		if (in_array($name, $this->_ci_services, TRUE))
		{
			return $this;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			throw new RuntimeException('The service name you are loading is the name of a resource that is already being used: '.$name);
		}

		if ( ! class_exists('MY_Service', FALSE))
		{
			load_class('Service', 'core');
		}

		$service = ucfirst($service);
		if ( ! class_exists($service))
		{
			foreach ($this->_ci_service_paths as $service_path)
			{
				if ( ! file_exists($service_path.'services/'.$path.$service.'.php'))
				{
					continue;
				}

				require_once($service_path.'services/'.$path.$service.'.php');
				if ( ! class_exists($service, FALSE))
				{
					throw new RuntimeException($service_path."services/".$path.$service.".php exists, but doesn't declare class ".$service);
				}

				break;
			}

			if ( ! class_exists($service, FALSE))
			{
				throw new RuntimeException('Unable to locate the service you have specified: '.$service);
			}
		}
		elseif ( ! is_subclass_of($service, 'MY_Service'))
		{
			throw new RuntimeException("Class ".$service." already exists and doesn't extend MY_Service");
		}

		$this->_ci_services[] = $name;
		$CI->$name = new $service();
		return $this;
	}

	/**
	 * 
	 * View Loader
	 *
	 * Loads "view" files.
	 *
	 * @param	string	$view	View name
	 * @param	array	$vars	An associative array of data
	 *				to be extracted for use in the view
	 * @param	bool	$return	Whether to return the view output
	 *				or leave it to the Output class
	 * @param	bool	$html_escape	是否转义数据，防止XSS
	 * @return	object|string
	 */
    public function view($view, $vars = array(), $return = FALSE, $html_escape = TRUE) {
    	if ($html_escape) {
    		$vars = my_html_escape($vars);
    	}
    	return parent::view($view, $vars, $return);
    }
    
	/**
	 * Set Variables
	 *
	 * Once variables are set they become available within
	 * the controller class and its "view" files.
	 *
	 * @param	array|object|string	$vars
	 *					An associative array or object containing values
	 *					to be set, or a value's name if string
	 * @param 	string	$val	Value to set, only used if $vars is a string
	 * @param	bool	$html_escape	是否转义数据，防止XSS
	 * @return	object
	 */
	public function vars($vars, $val = '', $html_escape = TRUE) {
    	if ($html_escape) {
    		$vars = my_html_escape($vars);
    		$val = my_html_escape($val);
    	}
    	return parent::vars($vars, $val);
	}

}
<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	public $module;
	private $located = 0;

	public function fetch_module()
	{
		return $this->module;
	}

	protected function _set_request($segments = array())
	{
		if ($this->translate_uri_dashes === TRUE)
		{
			foreach(range(0, 2) as $v)
			{
				isset($segments[$v]) && $segments[$v] = str_replace('-', '_', $segments[$v]);
			}
		}
		
		$segments = $this->locate($segments);

		if($this->located == -1)
		{
			$this->_set_404override_controller();
			return;
		}

		if(empty($segments))
		{
			$this->_set_default_controller();
			return;
		}
		
		$this->set_class($segments[0]);
		
		if (isset($segments[1]))
		{
			$this->set_method($segments[1]);
		}
		else
		{
			$segments[1] = 'index';
		}
       
		array_unshift($segments, NULL);
		unset($segments[0]);
		$this->uri->rsegments = $segments;
	}
	
	protected function _set_404override_controller()
	{
		$this->_set_module_path($this->routes['404_override']);
	}

	protected function _set_default_controller()
	{
		if (empty($this->directory))
		{
			/* set the default controller module path */
			$this->_set_module_path($this->default_controller);
		}

		parent::_set_default_controller();
		
		if(empty($this->class))
		{
			$this->_set_404override_controller();
		}
	}

	/** Locate the controller **/
	public function locate($segments)
	{
		// reset directory
		$this->directory = null;

		$this->located = 0;
		$ext = $this->config->item('controller_suffix').EXT;

		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;
		}

		$count_segment = count($segments);
		for ($i=0; $i < $count_segment; $i++) {
			$dir_module = $i == 0 ? $segments : array_slice($segments, 0, $i * -1);
			$dir_module = implode('/', $dir_module);
			foreach (Modules::$locations as $location => $offset){
				if (is_dir($source = $location.$dir_module.'/controllers/')){
					$this->module = $dir_module;
					$this->directory = $offset.$dir_module.'/controllers/';

					/* module sub-controller exists? */
					if(isset($segments[$count_segment - $i]) && is_file($source.ucfirst($segments[$count_segment - $i]).$ext)){
						$this->located = $count_segment - $i + 1;
						return array_slice($segments, $count_segment - $i);
					}

					/* module controller exists? */
					if(is_file($source.ucfirst($segments[$count_segment - 1 - $i]).$ext)){
						$this->located = $count_segment - $i;
						return array_slice($segments, $count_segment - 1 - $i);
					}
				}
			}
		}

		/* application controller exists? */
		if (isset($segments[0]) && is_file(APPPATH.'controllers/'.ucfirst($segments[0]).$ext)){
			return $segments;
		}

		
		$this->located = -1;
	}

	/* set module path */
	protected function _set_module_path(&$_route)
	{
		if ( ! empty($_route))
		{
			// Are module/directory/controller/method segments being specified?

			$args_segments = explode('/', $_route);
			$count_segments = count($args_segments);

			if ($this->locate($args_segments))
			{
				if ($this->located == 0) {
					$_route = current($args_segments).'/index';
				}else if ($count_segments == $this->located) {
					$_route = end($args_segments).'/index';
				}else if ($count_segments > $this->located) {
					$_route = $args_segments[$this->located - 1].'/'.$args_segments[$this->located];
				}
			}
		}
	}

	public function set_class($class)
	{
		$suffix = $this->config->item('controller_suffix');
		if (strpos($class, $suffix) === FALSE)
		{
			$class .= $suffix;
		}
		parent::set_class($class);
	}
}	
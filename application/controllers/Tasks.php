<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

	var $CI;
	var $current_table = 'tasks';
	var $base_url = '';
	var $table_url;
	var $tables_list;

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');

		$this->CI =& get_instance();
		
		$this->CI->load->database("", FALSE, TRUE);			
		$this->CI->load->library('pagination');
		// Turn off caching
		$this->CI->db->cache_off();

		$this->table_url = ( isset( $_GET['table'] ) ) ? "?table={$_GET['table']}" : '';
		$this->tables_list = $this->db->list_tables();	

		/**
		* If scaffolding disable is set to true, redirect to default controller
		*/
		if( $this->config->item('scaffolding_disable') )
		{
			redirect($this->router->default_controller);
			exit;
		}
				
		/**
		 * Set the current table name
		 */		
		$this->current_table = 'tasks';
		

		// Set the base URL
		$this->base_url = $this->CI->config->site_url().'/'.$this->CI->uri->segment(1).$this->CI->uri->slash_segment(2, 'both');
		$this->base_uri = $this->CI->uri->segment(1).$this->CI->uri->slash_segment(2, 'leading');

		// Set a few globals
		$data = array(
						'image_url'	=> $this->CI->config->system_url().'scaffolding/images/',
						'base_uri'  => $this->base_uri,
						'base_url'	=> $this->base_url,
						'title'		=> $this->current_table,
						'table_url' => $this->table_url,
						'tables' 	=> $this->tables_list			
					);
		
		$this->CI->load->vars($data);			

		// Load the language file
		$this->lang->load('tasks');
				
		//  Load the helper files we plan to use
		$this->CI->load->helper(array('url', 'form', 'date'));
		
				
		log_message('debug', 'Scaffolding Class Initialized');
	}
	function get_date(){
		//in my country
		//return date('Y-m-d H:i:s',now('Asia/Jakarta'));
	
		//global time just setting in your operating system 
		return date('Y-m-d H:m:s',now('Asia/Jakarta'));
	}
	
	/**
	 * "View" Page
	 *
	 * Shows a table containing the data in the currently
	 * selected DB
	 *
	 * @access	public
	 * @return	string	the HTML "view" page
	 */
	function index()
	{
		$total_rows = $this->db->count_all($this->current_table);
		
		if ($total_rows < 1)
		{
			$data = ['main_content' => 'tasks/no_data'];
			return $this->load->view('includes/template', $data);
		}
		
		// Set the query limit/offset
		$per_page = 100;
		$offset = $this->uri->segment(3, 0);
		$start = intval($this->input->get('start'));

		// Run the query
		$query = $this->db->get($this->current_table, $per_page, $offset);

		// Now let's get the field names				
		$fields = $this->db->list_fields($this->current_table);
		
		// We assume that the column in the first position is the primary field.
		$primary = current($fields);

		// Pagination!
		$this->pagination->initialize(
							array(
									'base_url'		 => site_url('tasks/index'),
									'total_rows'	 => $total_rows,
									'per_page'		 => $per_page,
									'uri_segment'	 => 3,
									'suffix' => $this->table_url,
									'full_tag_open'	 => '<p>',
									'full_tag_close' => '</p>'
									)
								);	

		$data = array(
						'title'	=>  $this->lang->line('scaff_view'),
						'main_content' => 'tasks/view',
						'query'		=> $query,
						'fields'	=> $fields,
						'primary'	=> $primary,
						'paginate'	=> $this->pagination->create_links(),
						'table_url' => $this->table_url,
						'start' => $start,
					);
		$this->load->view('includes/template', $data);
		
	}

	// --------------------------------------------------------------------
	
	/**
	 * "Add" Page
	 *
	 * Shows a form representing the currently selected DB
	 * so that data can be inserted
	 *
	 * @access	public
	 * @return	string	the HTML "add" page
	 */
	function add()
	{	
		$data = array(
						'title'	=>  $this->lang->line('scaff_add'),
						'main_content' => 'tasks/add',
 						'fields' => $this->db->field_data($this->current_table),
						'dateCreated' => $this->get_date(),
						'table_url' => $this->table_url		
					);
		
		$this->load->view('includes/template', $data);

	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Insert the data
	 *
	 * @access	public
	 * @return	void	redirects to the view page
	 */
	function insert()
	{		
		if ($this->db->insert($this->current_table, $_POST) === FALSE)
		{
			$this->add();
		}
		else
		{
			redirect('tasks'.$this->table_url);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * "Edit" Page
	 *
	 * Shows a form representing the currently selected DB
	 * so that data can be edited
	 *
	 * @access	public
	 * @return	string	the HTML "edit" page
	 */
	function edit()
	{
		if (FALSE === ($id = $this->CI->uri->segment(3)))
		{
			return $this->view();
		}

		// Fetch the primary field name
		$primary = $this->db->primary($this->current_table);		

		// Run the query
		$query = $this->db->get_where($this->current_table, array($primary => $id));	

		$data = array(
						'title'	=>  $this->lang->line('scaff_edit')." ".$this->current_table,
						'main_content' => 'tasks/edit',
						'fields'	=> $this->db->field_data($this->current_table),
						'dateUpdated' => $this->get_date(),
						'query'		=> $query->row(),						
						'table_url' => $this->table_url		
					);

		$this->load->view('includes/template', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update
	 *
	 * @access	public
	 * @return	void	redirects to the view page
	 */
	function update()
	{	
		// Fetch the primary key
		$primary = $this->db->primary($this->current_table);				

		// Now do the query
		$this->db->update($this->current_table, $_POST, array($primary => $this->CI->uri->segment(3)));
		
		redirect('tasks'.$this->table_url);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete Confirmation
	 *
	 * @access	public
	 * @return	string	the HTML "delete confirm" page
	 */
	function delete()
	{

		$data = array(
						'title'		=> $this->lang->line('scaff_delete'),
						'main_content' => 'tasks/delete',
						'message'	=> $this->lang->line('scaff_del_confirm').' '.$this->uri->segment(3),
						'no'		=> anchor('tasks'.$this->table_url, $this->lang->line('scaff_no')),
						'yes'		=> anchor('tasks/do_delete/'. $this->uri->segment(3).$this->table_url, $this->lang->line('scaff_yes')),
						'table_url' => $this->table_url		
					);
	
		$this->load->view('includes/template', $data);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Delete
	 *
	 * @access	public
	 * @return	void	redirects to the view page
	 */
	function do_delete()
	{		
		// Fetch the primary key
		$primary = $this->db->primary($this->current_table);				

		// Now do the query
		$this->db->where($primary, $this->CI->uri->segment(3));
		$this->db->delete($this->current_table);

		redirect('tasks'.$this->table_url);
		exit;
	}
}

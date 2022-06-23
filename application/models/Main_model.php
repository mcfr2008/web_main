<?php

class Main_model extends CI_Model {

    function __construct() {
      
        parent::__construct();

        $this->load->model('Activity_log_model');
        
    }

    public function login_model($data = array('')) 
    {

        $this->db = $this->load->database($data['database'], TRUE);

        $this->db->select('
			users.fld_id,
			users.fld_name,
			users.fld_username,
			users.fld_password,
			users.fld_lastlogin,
			users.fld_employee_id,
			users.fld_creator_id,
			users.fld_create_date,
			user_access.fld_role_id

        ');
        $this->db->from('users');
        $this->db->join('user_access','user_access.fld_user_id = users.fld_id','left');	
        $this->db->where('users.fld_username',$data['username']);
        $this->db->where('users.fld_password',$data['password']);
        $data_user = $this->db->get()->result_array()[0];

        if(count($data_user) > 0){
            $this->session->set_userdata('people_login', 1);
            $this->session->set_userdata('people_id', $data_user['fld_id']);
            $this->session->set_userdata('people_username', $data_user['fld_username']);
            $this->session->set_userdata('people_password', $data_user['fld_password']);
            $this->session->set_userdata('people_name', $data_user['fld_name']);
            // $this->session->set_userdata('people_part_id', $data_user['fld_part_id']);
            // $this->session->set_userdata('people_depart_id', $data_user['fld_depar_tid']);
            $this->session->set_userdata('people_role', $data_user['fld_role_id']);
            $this->session->set_userdata('people_employee', $data_user['fld_employee_id']);
            $this->session->set_userdata('people_database',$data['database']);
             
            $result['people_login'] = 1;

            //-------------------------------------Activity_log-------------------------------------------------
                $data_activity_log = array();
                $data_activity_log = array(
                    "fld_activity" => 'เข้าสู่ระบบสำเร็จ รหัสผู้เข้าใช้งาน ' . $data['username'] ,
                    "fld_table_name" => '',
                    "fld_table_id" => '',
                    "fld_creator_id" => $_SESSION['people_employee'],
                    "fld_creator_date" => date('Y-m-d H:i:s')
                );
                $this->Activity_log_model->add_activity_log_1_model($data_activity_log);
            //-------------------------------------END-Activity_log--------------------------------------------
        }else{
             //-------------------------------------Activity_log-------------------------------------------------
                $data_activity_log = array();
                $data_activity_log = array(
                    "fld_activity" => 'เข้าสู่ระบบไม่สำเร็จ รหัสผู้เข้าใช้งาน ' . $data['username'] ,
                    "fld_table_name" => '',
                    "fld_table_id" => '',
                    "fld_creator_id" => '',
                    "fld_creator_date" => date('Y-m-d H:i:s')
                );
                $this->Activity_log_model->add_activity_log_1_model($data_activity_log);
            //-------------------------------------END-Activity_log--------------------------------------------
        }

        return $result;
    }

    public function appMenu()
    {
        if ($this->session->userdata('people_role') == 0) {

            $this->db->select('
				role_application.*  
			');
			$this->db->from('role_application');
			$this->db->join('role_function','role_function.fld_application_id = role_application.fld_id');
			$this->db->join('user_access','user_access.fld_function_id = role_function.fld_id ');	
			$this->db->where('user_access.fld_function_id', $this->session->userdata('people_id'));
			// $this->db->where('role_application.fld_id <> ',5);
            $this->db->group_by('role_application.fld_id');
			$data = $this->db->get()->result_array();
				
			
        } else {

            $this->db->select('
				role_application.*  
            ');
            $this->db->from('role_application');
			$this->db->join('role_function','role_function.fld_application_id = role_application.fld_id');
            $this->db->join('role_access','role_function.fld_id = role_access.fld_function_id');	
            $this->db->where('role_access.fld_role_id',$this->session->userdata('people_role'));
			// $this->db->where('role_application.fld_id <> ',5);
			$this->db->group_by('role_application.fld_id');
            $data = $this->db->get()->result_array();
        }
       
        return  $data ;
    }
  
}

?>

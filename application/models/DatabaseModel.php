<?php

/**
 * 
 */
class DatabaseModel extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function validateLogin($email,$password)
	{
		$this->db->where('email',$email);
        $this->db->where('status','1');
        $query = $this->db->get('users');
        if($query->num_rows() == 1)
        {
            $result = $query->result();
            if(password_verify($password, $result[0]->password))
            {
                return $result[0]->id;
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 0;
        }
	}

	public function saveData($table,$data)
    {
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

	public function exists($table,$param)
	{
		$query = $this->db->get_where($table,$param);
        $num_rows = ($query->num_rows());

        if($num_rows == 1){
            return true;
        }else{
            return false;
        }
	}


	public function update($table,$data,$col,$value)
	{
		$this->db->where($col,$value);
        $this->db->update($table,$data);

        return true;
	}

	public function getData($table,$condition,$order='asc')
    {
        $this->db->order_by('id',$order);
        $query = $this->db->get_where($table,$condition);

        return $query->result_array();
    }

    public function getField($field, $table, $id)
    {
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where('id',$id);
        return $this->db->get()->row($field);
    }

    public function delete($table, $param)
    {
        if($this->db->delete($table, $param))
        {
            return true;
        }
        return false;
    }

}

?>
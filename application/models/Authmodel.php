<?php
class Authmodel extends CI_model
{
	function validate($username, $password)
	{
		$query = "SELECT *
		FROM users u
		WHERE username = '$username'
		AND password = '$password'";
		$rs = $this->db->query($query);
		$user = $rs->num_rows();
		return $user;
	}
	
	function getuser($username, $password)
	{
		$query = "SELECT u.id as user_id, u.role_id, r.role
		FROM users u
		LEFT JOIN roles r ON r.id = u.role_id
		WHERE u.username = '$username'
		AND u.password = '$password'";
		$rs = $this->db->query($query);
		$user = $rs->row_array();
		return $user;
	}
}

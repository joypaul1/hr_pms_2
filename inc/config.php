<?php
define("HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "rangs_hr_rml");

$conn_hr = mysqli_connect(HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn_hr) {
	die(mysqli_error());
}

function getUserAccessRoleByID($id)
{
	global $conn_hr;
	$query = "select user_role from tbl_user_role where  id = " . $id;

	$rs = mysqli_query($conn_hr, $query);
	$row = mysqli_fetch_assoc($rs);

	return $row['user_role'];
}

function checkPermission($permissionSlug)
{
	global $conn_hr;
	$isPermission = false;
	$permissionName = getUserWisePermissionName();

	if (count($permissionName) > 0) {
		$allperSlug = array_column($permissionName, 'slug');
		if (in_array($permissionSlug, $allperSlug)) {
			$isPermission = true;
		}
		return $isPermission;
	} else {
		$permissionArray = [];
		$permissionSlugData = [];
		
		$rolesql        = "SELECT * FROM tbl_roles_permissions  Where role_id =7"; //  select query execution
		$result     = mysqli_query($conn_hr, $rolesql);
		if ($result) {
			while ($row = mysqli_fetch_array($result)) {
				$permissionArray[] = array(
					'permission_id' => $row['permission_id']
				);
			}
		}
		$permissionArray = array_column($permissionArray, 'permission_id');
		foreach ($permissionArray as $key => $value) {
			$sql        = "SELECT * FROM tbl_permissions  Where id=" . $value; //  select query execution
			$perResult     = mysqli_query($conn_hr, $sql);
			if ($perResult) {
				while ($row = mysqli_fetch_array($perResult)) {
					$permissionSlugData[] = array(
						'slug' => $row['slug']
					);
				}
			}
		}
		$allperSlug = array_column($permissionSlugData, 'slug');
		if (in_array($permissionSlug, $allperSlug)) {
			$isPermission = true;
		}
		return $isPermission;
		
	}
}

function getUserWisePermissionName()
{
	global $conn_hr;

	$user_id = $_SESSION['HR']['id_hr'];
	$permissionArray = [];
	$permissionSlug = [];
	$sql        = "SELECT * FROM tbl_users_permissions  Where user_id=" . $user_id; //  select query execution
	$result     = mysqli_query($conn_hr, $sql);
	// Loop through the fetched rows
	if ($result) {
		while ($row = mysqli_fetch_array($result)) {
			$permissionArray[] = array(
				'permission_id' => $row['permission_id']
			);
		}
	}
	// print_r( $permissionArray); die();
	$permissionArray = array_column($permissionArray, 'permission_id');
	foreach ($permissionArray as $key => $value) {
		$sql        = "SELECT * FROM tbl_permissions  Where id=" . $value; //  select query execution
		$perResult     = mysqli_query($conn_hr, $sql);
		if ($perResult) {
			while ($row = mysqli_fetch_array($perResult)) {
				$permissionSlug[] = array(
					'slug' => $row['slug']
				);
			}
		}
	}
	return $permissionSlug;
}

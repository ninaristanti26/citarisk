<?php 
 
$mysqli = mysqli_connect("localhost","bprsukab_clara1","putrisaljudan7kurcaci","bprsukab_clara1");
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
 
?>
<?php 
$user_id = get_current_user_id();
$user = get_userdata($user_id);
if(isset($_POST['update'])){
    $user_id = esc_sql($_POST['user_id']);
    $fname = esc_sql($_POST['user_fname']);
    $lname = esc_sql($_POST['user_lname']);

    $usermeta = array(
        'ID' => $user_id,
        'first_name' =>$fname,
        'last_name' => $lname,
    );
    $user = wp_update_user($usermeta);
    if(is_wp_error( $user )){
        echo "can not update " . $user->get_error_message();
    }
}
if($user != false){
    $gender = get_usermeta($user_id,'gender');
    $fname = get_usermeta($user_id,'first_name');
    $lname = get_usermeta($user_id,'last_name');
}
?>
<h2>Hi <?php echo $fname . " ".$lname?></h2>
<p><a href="<?php echo wp_logout_url();?>">Logout</a></p>

<form action="<?php echo get_the_permalink();?>" method="post">
    First Name : <input type="text" name="user_fname" value="<?php echo $fname;?>" />
    Last Name : <input type="text" name="user_lname" value="<?php echo $lname;?>" />
    <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
    <input type="submit" value="update" name="update" />
</form>
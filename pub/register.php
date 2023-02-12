<?php
if(isset($_POST['register'])){
    global $wpdb;

    $fname = $wpdb->escape($_POST['user_fname']);
    $lname = $wpdb->escape($_POST['user_lname']);
    $username = $wpdb->escape($_POST['user_name']);
    $email = $wpdb->escape($_POST['user_email']);
    $pass = $wpdb->escape($_POST['user_pass']);
    $con_pass = $wpdb->escape($_POST['user__con_pass']);

    if($pass == $con_pass){

        //$result = wp_create_user($username, $pass, $email);
        $user_data = array(
            'user_login' =>$username,
            'user_email' =>$email,
            'first_name' =>$fname,
            'last_name' =>$lname,
            
            'display_name' =>$lfname .' ' .$lname,
            'user_pass'   =>$pass
            
        );
        $result = wp_insert_user($user_data);
        if(!is_wp_error( $result)){
            echo "User Created ID".$result;
            add_user_meta($result, 'gender','male');
            update_user_meta($result,'show_admin_bar_front',false);
        }else{
            echo $result->get_error_message();
        }
    }else {
        echo "Password must Match";
    }
}
?>
<div class="form_wrapper">


    <div class="reg">
        <h2>Register Form</h2>
        <form action="<?php echo get_the_permalink();?>" method="post">
            First Name : <input type="text" name="user_fname" id="user-fname" /> <br />
            Last Name : <input type="text" name="user_lname" id="user-lname" /> <br />
            User Name : <input type="text" name="user_name" id="username" /> <br />
            User Email : <input type="email" name="user_email" id="user-email" /> <br />
            Password : <input type="password" name="user_pass" id="user-pass" /> <br />
            Confirm Password : <input type="password" name="user__con_pass" id="user-con-pass" /> <br />
            <input type="submit" class="button" name="register" value="Register" />
        </form>
    </div>
</div>
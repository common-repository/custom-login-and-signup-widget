<?php
    /* 
    Plugin Name: Custom Login and Signup Widget
    Plugin URI: http://www.bitto.us
    Description: Custom Login And Signup Widget plugin gives your site the ability to put custom meta widget for login, signup and password reset with javascript effect. no jquery needed. just install the plugin and put the widget where you wish. you can also customize the signup email and password reset email sender's email address and sender name. Plugin <a href="http://bitto.us/wp/">Demo</a>. plugin developed by <a href="http://bitto.us">Bitto Kazi</a>
    Author: Bitto Kazi
    Version: 1.0 
    Author URI: http://www.bitto.us
    */
	if(function_exists ('home_url')) {
global $loginse;
global $bwbn;
global $sender;
$loginse=0;
function check_user_clsw() {
global $loginse;
  if(isset($_POST['check']) && $_POST['check'] == 'clsw' && isset($_POST['pwd']) && $_POST['pwd'] != '' ) {

  // see the codex for wp_signon()
  $result = wp_signon();

  if(is_wp_error($result))
    {
	$loginse=2;
	}
	else {
  // redirect back to the requested page if login was successful    
  header('Location: ' . $_SERVER['REQUEST_URI']);
  exit;
  }
  }
  }

	





//widget page
	class wpb_widget11 extends WP_Widget {
function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget1',
// Widget name will appear in UI
__('Custom Login and Signup', 'wpb_widget1_domain'),
// Widget description
array( 'description' => __( 'Custom Login and Signup with Password reset bar', 'wpb_widget1_domain' ), )
);
}
// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];
// This is where you run the code and display the output
//my code

global $loginse;
echo'
<script>
function changeClass(i,j){
	var x=1;
    var NAME = document.getElementById("first_name"+i);
    var currentClass = NAME.className;
    if (currentClass == "inactive") { // Check the current class name
        NAME.className = "active";   // Set other class name
		while(x<=j) {
		if(x!=i) {
			NAME = document.getElementById("first_name"+x);
			currentClass = NAME.className;
			if (currentClass == "active") { // Check the current class name
				NAME.className = "inactive";   // Set other class name
			}
		}
		x++;
		}
    } else {
          // Otherwise, use `second_name`
    }
	
	x=1
	NAME = document.getElementById("link"+i);
	currentClass = NAME.className;
    if (currentClass == "none1") { // Check the current class name
        NAME.className = "currentli";   // Set other class name
		while(x<=j) {
		if(x!=i) {
			NAME = document.getElementById("link"+x);
			currentClass = NAME.className;
			if (currentClass == "currentli") { // Check the current class name
				NAME.className = "none1";   // Set other class name
			}
		}
		x++;
		}
    } else {
          // Otherwise, use `second_name`
    }
}  
</script>
';



@include('content/sn.php');
@include('content/sm.php');

global $bwbn;
global $sender;

       

        // check if we're in reset form
        if( isset( $_POST['action'] ) && 'reset' == $_POST['action'] ) 
        {
		 global $wpdb;

        $error = '';
        $success = '';
            $email = $wpdb->escape(trim($_POST['email1']));

            if( empty( $email ) ) {
                $error = 'Enter an e-mail address..';
            } else if( ! is_email( $email )) {
                $error = 'Invalid e-mail address.';
            } else if( ! email_exists( $email ) ) {
                $error = 'There is no user registered with that email address.';
            } else {

                $random_password = wp_generate_password( 12, false );
                $user = get_user_by( 'email', $email );

               $update_user = wp_update_user( array (
                        'ID' => $user->ID, 
                        'user_pass' => $random_password
                    )
                );

                // if  update user return true then lets send user an email containing the new password
                if( $update_user ) {
                    $to = $email;
                    $subject = get_bloginfo( 'name' ).' - Reset Your password';
                    if($sender=='') { $sender = 'no-reply@'.$_SERVER['SERVER_NAME']; }
					if($bwbn=='') { $bwbn = 'no-reply@'.$_SERVER['SERVER_NAME']; }

                    $message = 'Your username: '.get_the_author_meta('user_login',$user->ID).' Your new password is: '.$random_password.'  powered by '.$bwbn.' ( http://'.$_SERVER['SERVER_NAME'].' )';

                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers[] = "X-Mailer: PHP \r\n";
                    $headers[] = 'From: '.$bwbn.' <'.$sender.'>' . "\r\n";

 
                    if(  wp_mail( $to, $subject, $message, $headers ) )
                        $success = 'Check your email address for you new password.';

                } else {
                    $error = 'Oops something went wrong updaing your account.';
                }

            }

        }
		
		
	$uns='';	
$une='';		
		if(isset($_POST['username']) && $_POST['username']!='' && isset($_POST['email']) && $_POST['email']!='') {
$user_name=$_POST['username'];
$random_password = wp_generate_password( 12, false );
$user_email=$_POST['email'];
$user_id = username_exists( $user_name );
if ( !$user_id and email_exists($user_email) == false ) {

	$user_id = wp_create_user( $user_name, $random_password, $user_email );


$to = $user_email;
                    $subject = get_bloginfo( 'name' ).' - Your new password';
                    if($sender=='') { $sender = 'no-reply@'.$_SERVER['SERVER_NAME']; }
					if($bwbn=='') { $bwbn = 'no-reply@'.$_SERVER['SERVER_NAME']; }

                    $message = 'Welcome, '.$user_name.' to '.get_bloginfo( 'name' ).'. Your new password is: '.$random_password.'  powered by '.$bwbn.' ( http://'.$_SERVER['SERVER_NAME'].' )';

                    $headers[] = 'MIME-Version: 1.0' . "\r\n";
                    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers[] = "X-Mailer: PHP \r\n";
                    $headers[] = 'From: '.$bwbn.' <'.$sender.'>' . "\r\n";

                    $mail = wp_mail( $to, $subject, $message, $headers );
                    if( $mail ) {
	$uns='SIGN-UP SUCCESSFULL!!! Please Check your inbox for password';
}
} else {
	$une='Username or email exists';
}
}














echo'<div class="listdiv"><div class="list">';
if(!is_user_logged_in()){
echo'<div class="currentli" id="link1"><a href="#link1" onclick="changeClass(1,3);">Login</a></div>';
echo'<div class="none1" id="link2"><a href="#link2" onclick="changeClass(2,3);">Signup</a></div>
<div class="none1" id="link3"><a href="#link3" onclick="changeClass(3,3);">Reset</a></div>';
}
echo'</div>
<div class="clear:both;"></div>
<div class="cont">
<div class="active" id="first_name1">
';
if(!is_user_logged_in()){
if($loginse==2) { echo'<p>Wrong Username or Password</p>'; }
else if ($success!='') { echo'<p>'.$success.'</p>';  }
else if ($error!='') { echo'<p>'.$error.'</p>';  }
else if ($uns!='') { echo'<p>'.$uns.'</p>';  }
else if ($une!='') { echo'<p>'.$une.'</p>';  }
echo '<form action="" method="post" style="text-align-left; width:91%; padding:10px;">
  <div>
    <p>UserName: <span class="red">*</span></p> <input name="log" type="text"  style="width:100%; height:20px; border-color: rgb(0, 0, 0);" />
  </div>
  <div>
    <p>PassWord: <span class="red">*</span></p> <input name="pwd" type="password"  style="width:100%; height:20px; border-color: rgb(0, 0, 0);" />
  </div>
<input type="hidden" name="check" value="clsw" />
  <div><br>
    <input type="submit" value="Login" style="border-width:0px; width:70px; height:27px; text-align:center; font-size:17px; float:left; background:#5db8f0;"/>

  </div>
</form>';
}
else  {
global $current_user;
get_currentuserinfo();
$user_id = get_current_user_id();
if ($user_id == 0) {
    echo 'You are currently not logged in.';
} else {
echo '<div style="float:left;">'.get_avatar( $current_user->user_email, 128 ).'</div><br>';
    echo '<div style="float:left;">Welcome back,<br>';
	echo 'Username: ' . $current_user->user_login . "<br>";
      echo 'User email: ' . $current_user->user_email . "<br>";
      echo 'User first name: ' . $current_user->user_firstname . "<br>";
      echo 'User last name: ' . $current_user->user_lastname . "<br>";
      echo 'User display name: ' . $current_user->display_name . "<br>";
	  echo 'Go to <a style="text-decoration:underlined;" target="_blank" href="'.home_url().'/wp-admin/">DASHBOARD</a><br>';
	   echo 'Or <a style="text-decoration:underlined;" href="'.wp_logout_url( home_url() ).'">Sign-Out?</a></div>';
}
}

echo'</div>
<div class="inactive" id="first_name2">
';


if ($uns!='') { echo'<p>'.$uns.'</p>';  }
else if ($une!='') { echo'<p>'.$une.'</p>';  }


echo'   <form method="post" action="" style="text-align-left; width:91%; padding:10px;">                          
<p>UserName: <span class="red">*</span></p>
                            <input name="username" type="text" maxlength="100" id="txtStudentName" class="bor" style="width:100%; height:20px; border-color: rgb(0, 0, 0);">
                            <p>Email: <span class="red">*</span></p>
                            <input name="email" type="text" maxlength="200" id="txtEmailAddress" class="bor"  style="width:100%; height:20px; border-color: rgb(0, 0, 0);">
							

<br><br>

                           <left><p style="margin-top:-5px; width:50px;"><input type="submit" value="Signup" style="border-width:0px; width:70px; height:27px; text-align:center; font-size:17px; float:left; background:#5db8f0;"></form></p></left>
';








echo'
</div>
<div class="inactive" id="first_name3">
';













		
		
		
		
		
 if ($success!='') { echo'<p>'.$success.'</p>';  }
else if ($error!='') { echo'<p>'.$error.'</p>';  }		
		
		
		
		
		echo '
		<form method="post" style="text-align-left; width:91%; padding:10px;">
            <p>Please enter your email address. You will receive a link to create a new password via email.</p>
            <p><label for="user_login">E-mail:</label>
                <input type="text" name="email1" id="user_login"  value="" /></p>
            <p>
                <input type="hidden" name="action" value="reset" />
                <input type="submit" value="Get New Password" class="button" id="submit" style="border-width:0px; height:27px; text-align:center; font-size:17px; float:left; background:#5db8f0;"/>
            </p>
    </form>
		';
		
		
		
		
		
		
		
		
		
		
		
		



















echo'
</div>
</div>
</div>
<div style="clear:both;"></div>
';


//my code
echo __( $gutghutghut, 'wpb_widget1_domain' );
echo $args['after_widget'];
}
// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Login or Signup', 'wpb_widget1_domain' );
}
// Widget admin form
echo '
<p>
<label for="'; echo $this->get_field_id( 'title' ); echo'">'; _e( 'Title:' ); echo'</label>
<input class="widefat" id="'; echo $this->get_field_id( 'title' ); echo'" name="'; echo $this->get_field_name( 'title' ); echo'" type="text" value="'; echo esc_attr( $title ); echo'" />
</p>';
}
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget1 ends here
// Register and load the widget
function wpb_load_widget1() {
    register_widget( 'wpb_widget11' );
}

add_action( 'widgets_init', 'wpb_load_widget1' );



function custom_l_s_w() {
wp_register_style( 'clsw', 
    plugins_url( 'clsw.css', __FILE__ ), 
    array(), 
    '201202081', 
    'all' );
wp_enqueue_style( 'clsw' );
}
add_action('wp_enqueue_scripts', 'custom_l_s_w');
add_action('wp_loaded','check_user_clsw');


function frndzk_adminclsw() {  
include('frndzk_adminclsw.php'); 
}
function frndzk_admin_actionsclsw() {  
    add_options_page("Custom Login And Signup Widget", "Custom Login And Signup Widget", "manage_options","custom-login-and-signup-widget","frndzk_adminclsw");  
}
add_action('admin_menu', 'frndzk_admin_actionsclsw');




function edit_sender_name() {
$ler="bwbn";
$contentst=$_POST['text'];
$contentst="<?php
global $$ler;
$$ler='$contentst';
?>";
$contentst=str_replace('\"','"',$contentst);
$contentst=str_replace("\'","'",$contentst);
$contentst = stripslashes($contentst);
$file = fopen(plugin_dir_path( __FILE__ ).'/content/sn.php',"w");
$stringData = "$contentst";
fwrite($file,$stringData);
fclose($file);
echo'Success<br>';
}

function edit_sender_email() {
$ler="sender";
$contentst=$_POST['text'];
$contentst="<?php
global $$ler;
$$ler='$contentst';
?>";
$contentst=str_replace('\"','"',$contentst);
$contentst=str_replace("\'","'",$contentst);
$contentst = stripslashes($contentst);
$file = fopen(plugin_dir_path( __FILE__ ).'/content/sm.php',"w");
$stringData = "$contentst";
fwrite($file,$stringData);
fclose($file);
echo'Success<br>';
}
function edit_sender_email1() {
$ler="bwbn";
$contentst=$_POST['text'];
$contentst="<?php
global $$ler;
$$ler='$contentst';
?>";
$contentst=str_replace('\"','"',$contentst);
$contentst=str_replace("\'","'",$contentst);
$contentst = stripslashes($contentst);
$file = fopen(plugin_dir_path( __FILE__ ).'/content/sn.php',"w");
$stringData = "$contentst";
fwrite($file,$stringData);
fclose($file);
echo'Success<br>';
}



}
else {
echo 'UNATHORIZED ACCESS... YOU BETTER GET YOUR ASS OUT OF HERE>>>>>> :) ok baby';
}
?>
<?php
/* Template Name: Login Template Template */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if(!get_current_user_id()){
		//kullanıcı giriş yapmamış

		$object = new stdClass();
		$object->personalNumber = $_POST["personalNumber"];
		$object->username = "testuser" . rand(0,999999);
		$object->email = rand(0,999999) ."testuser@localhost.com";
		$loginstatus = loginWithUsername($object);


		if($loginstatus){
			header("refresh: 0;");
		}
	}
}

get_header();



/* Start the Loop */
while ( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/content/content-page' );

	if(!get_current_user_id()){
?><div style="max-width:1000px; margin:0 auto;">
<form action="" method="post">
	<input type="text" name="personalNumber"><br>
	<button type="submit">
		Giriş Yap
	</button>
</form>
</div>
<?php
	}else {
		$currentUser = get_user_by("id",get_current_user_id());
		//var_dump($currentUser);
		?>
		<div style="max-width:1000px; margin:0 auto;">
			<label for="username">Kullanıcı Adı</label><br /><input type="text" name="username" value="<?= $currentUser->data->user_login ?>"><br />
			<label for="email">email</label><br /><input type="text" name="email"  value="<?= $currentUser->data->user_email ?>"><br />
			<label for="personalNumber">personalNumber</label><br /><input type="text" name="personalNumber"  value="<?= get_user_meta(get_current_user_id(),"personalNumber",true) ?>"><br />
			<label for="userID">userID</label><br /><input type="text" name="userID"  value="<?= get_current_user_id() ?>"><br />

		</div>

	<?php }





	// If comments are open or there is at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
endwhile; // End of the loop.

get_footer();

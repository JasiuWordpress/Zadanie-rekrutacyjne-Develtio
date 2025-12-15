<?php
add_action('init', function () {
	add_shortcode('dl_profil', 'dl_profil_shortcode');
});

function dl_profil_shortcode() {
	ob_start();



/* user nie zalogowany */

if(!is_user_logged_in()){

	if (isset($_GET['dl_err'])) {
		$msg = match ($_GET['dl_err']) {
			'login'    => 'Nieprawidłowy login/e-mail lub hasło.',
			'required' => 'Wypełnij wszystkie pola.',
			'exists'   => 'Taki login lub e-mail już istnieje.',
			'register' => 'Nie udało się utworzyć konta.',
			'nonce'    => 'Sesja wygasła. Spróbuj ponownie.',
			default    => 'Wystąpił błąd.',
		};
		echo '<div class="dl-notice dl-notice--error"><p>' . esc_html($msg) . '</p></div>';
	}
	?>
	<div class="dl-auth">
		<section class="dl-auth__col dl-auth__login">
			<h2>Logowanie</h2>

			<form class="dl-form dl-form--login" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				<input type="hidden" name="action" value="dl_login">
				<?php wp_nonce_field('dl_login', 'dl_nonce'); ?>

				<p class="dl-field">
					<label>Login lub e-mail<br>
						<input type="text" name="dl_login" required>
					</label>
				</p>

				<p class="dl-field">
					<label>Hasło<br>
						<input type="password" name="dl_password" required>
					</label>
				</p>

				<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/moje-konto/') ); ?>">

				<p class="dl-actions">
					<button type="submit">Zaloguj</button>
				</p>
			</form>
		</section>

		<section class="dl-auth__col dl-auth__register">
			<h2>Rejestracja</h2>

			<form class="dl-form dl-form--register" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				<input type="hidden" name="action" value="dl_register">
				<?php wp_nonce_field('dl_register', 'dl_nonce'); ?>

				<p class="dl-field">
					<label>Login<br>
						<input type="text" name="dl_login" required>
					</label>
				</p>

				<p class="dl-field">
					<label>E-mail<br>
						<input type="email" name="dl_email" required>
					</label>
				</p>

				<p class="dl-field">
					<label>Hasło<br>
						<input type="password" name="dl_password" required>
					</label>
				</p>

				<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/moje-konto/') ); ?>">

				<p class="dl-actions">
					<button type="submit">Zarejestruj</button>
				</p>
			</form>
		</section>
	</div>
	<?php

	return ob_get_clean();
}else{

/* user zalogowany */
$user = wp_get_current_user();
ob_start();
?>

<h2>Witaj <?php echo $user->nickname ?></h2>

<?php

return ob_get_clean();
	}
}

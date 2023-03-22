<?php

namespace Framework\Settings;

class Phpmailer {

	private $isTest;

	public function __construct() {
		add_action( 'phpmailer_init', [ $this, 'PHPMailerSettings' ] );
		add_action( 'admin_notices', [ $this, 'showAdminNotice' ] );
	}

	/* ---
	  Functions
	--- */

	public function PHPMailerSettings( $PHPMailer ) {
		$this->setCustomSettings( $PHPMailer );
		if ( $this->isTest ) {
			$PHPMailer->SMTPDebug = 3;
		}
	}

	private function setCustomSettings( $PHPMailer ) {
		if ( ! function_exists( 'get_field' ) || ! get_field( 'wpf_phpmailer_active', 'option' )
			|| ( ! $settings = get_field( 'wpf_phpmailer', 'option' ) ) ) {
			return;
		}

		$PHPMailer->IsSMTP();
		$PHPMailer->SMTPDebug  = $settings['debug_level'];
		$PHPMailer->Host       = $settings['host'];
		$PHPMailer->SMTPAuth   = true;
		$PHPMailer->Username   = $settings['username'];
		$PHPMailer->Password   = $settings['password'];
		$PHPMailer->SMTPSecure = $settings['secure'];
		$PHPMailer->Port       = $settings['port'];
		$PHPMailer->From       = $settings['username'];
		$PHPMailer->FromName   = get_bloginfo( 'name' );

		if ( empty( $settings['secure'] ) ) {
			$PHPMailer->SMTPAutoTLS = false;
		} else {
			if ( $settings['secure'] == 'ssl' ) {
				$PHPMailer->SMTPOptions = [
					'ssl' => [
						'verify_peer'       => false,
						'verify_peer_name'  => false,
						'allow_self_signed' => true,
					],
				];
			}
		}
	}

	public function showAdminNotice() {
		if ( ! isset( $_GET['page'] ) || ( $_GET['page'] !== 'wpf-phpmailer' ) ) {
			return;
		}

		$status = $this->checkSettings();
		?>
		<div class="notice notice-info">
			<form action="" method="POST">
				<?php if ( $status ) : ?>
					<p>
					<pre><?php echo $status; ?></pre>
					</p>
				<?php endif; ?>
				<p>
					<input type="text" name="wpf_email" placeholder="<?php echo __( 'Enter your e-mail', 'wpf' ); ?>">
				</p>
				<p>
					<button type="submit" class="button button-primary">
						<?php echo __( 'Test your settings', 'wpf' ); ?>
					</button>
				</p>
			</form>
		</div>
		<?php
	}

	private function checkSettings() {
		if ( ! isset( $_POST['wpf_email'] ) ) {
			return;
		}

		$this->isTest = true;
		ob_start();

		$status = wp_mail(
			$_POST['wpf_email'],
			__( 'Test e-mail', 'wpf' ),
			__( 'This is a test message.', 'wpf' ),
			__( 'Test e-mail', 'wpf' )
		);

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

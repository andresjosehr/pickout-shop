<?php
$this->renderPartial('/front/banner-receipt',array(
   'h1'=>t("Login & Signup"),
   'sub_text'=>t("sign up to start ordering")
));

echo CHtml::hiddenField('mobile_country_code',Yii::app()->functions->getAdminCountrySet(true));
?>

<style>
	@media only screen and (min-width: 1025px) {
		.register-left {
			background:url("../assets/images/reg_left.jpg");
			width:40%;
			position: absolute;
			left: 0px;
			min-height:500px;
			text-align: center;
		}

		.register-right {
			background:url("../assets/images/reg_right.jpg");
			width:40%;
			position: absolute;
			right: 0px;
			min-height:500px;
		}

		.register-middle {
			background:url("../assets/images/middle.png");
			width:40%;
			min-height:500px;
			position: absolute;
			background-repeat: no-repeat;
			background-size: cover;
			left: 30%;
			z-index: 1;
		}

		.register-container {
			width: 100%;
		}

		.register-row {
			display: flex;
			min-height: 500px;
		}

		.register-button {
			background: rgba(0, 0, 0, 0.7);
			padding: 16px;
			border-radius: 10;
			border-radius: 37px;
			color: white;
			font-size: 16px;
			cursor: context-menu;
			position: absolute;
			min-width: 200px;
			text-align: center;
		}

		.register-button:hover{
			color: beige;
			text-decoration: none;
			background: rgba(20, 20, 20, 0.7);
		}

		.button-left {
			bottom: 10%;
			left: 30%;
		}	

		.button-right {
			bottom: 10%;
			right: 30%;
		}	

		.button-middle {
			top: 10%;
			left: 34%;
		}
	}

	@media only screen and (max-width: 1024px) {
		.register-left {
			background:url("../assets/images/reg_left.jpg");
			width:100%;
			min-height:500px;
			text-align: center;
		}

		.register-right {
			background:url("../assets/images/reg_right.jpg");
			width:100%;
			min-height:500px;
		}

		.register-middle {
			background:url("../assets/images/middle.png");
			width:100%;
			min-height:500px;
			background: white;
		}

		.register-container {
			width: 100%;
		}

		.register-button {
			background: rgba(0, 0, 0, 0.7);
			padding: 16px;
			border-radius: 10;
			border-radius: 37px;
			color: white;
			font-size: 16px;
			cursor: context-menu;
			min-width: 200px;
			text-align: center;
		}

		.register-button:hover{
			color: beige;
			text-decoration: none;
			background: rgba(20, 20, 20, 0.7);
		}

		.button-left {
			bottom: 10%;
			left: 30%;
		}	

		.button-right {
			bottom: 10%;
			right: 30%;
		}	

		.button-middle {
			top: 10%;
			left: 34%;
		}

	}
</style>

<div class="sections section-grey2 section-checkout">

<div class="container register-container">

  <div class="register-row">
		<div class="register-left">
			<?php echo'<a href="'.$driver_url.'" class="register-button button-left">'.t("Driver Signup").'</a>';?>
		</div>

		<div  class="register-middle">
		  <?php echo'<a href="'.$rest_url.'" class="register-button button-middle">'.t("Restaurant Signup").'</a>';?>
		</div>
		<div class="register-right">
			<?php echo'<a href="'.$client_url.'" class="register-button button-right">'.t("Signup").'</a>';?>
		</div>
  </div> <!--row-->

</div> <!--container-->

</div> <!--section-grey-->
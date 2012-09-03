<div class="right">
    <div class="notification">
        <a class="count" href="ajax/notifications.html"><span>10</span></a>
    </div>
	<div class="userinfo">
		<?php if($loggedin_user != FALSE){ ?>
			<a href="<?php echo url::site().$loggedin_role;?>"><img src="<?php echo members::gravatar($loggedin_user->email,20); ?>" width="20" />
			<span class="header_nav_label"><?php echo $loggedin_user->username; ?></span> 
			</a>

     </div><!--userinfo-->
            
    <div class="userinfodrop">
        <div class="avatar">
            <a href="#"><img src="images/thumbs/avatarbig.png" alt="" /></a>
        </div><!--avatar-->
        <div class="userdata">
            <h4><?php echo $loggedin_user->username; ?></h4>
			<?php if($loggedin_role != ""){ ?>
					<li><a href="<?php echo url::site().$loggedin_role;?>/profile"><?php echo Kohana::lang('ui_main.manage_your_account'); ?></a></li>

					<li><a href="<?php echo url::site().$loggedin_role;?>"><?php echo Kohana::lang('ui_main.your_dashboard'); ?></a></li>
				<?php } ?>
					<li><a href="<?php echo url::site();?>profile/user/<?php echo $loggedin_user->username; ?>"><?php echo Kohana::lang('ui_main.view_public_profile'); ?></a></li>

					<li><a href="<?php echo url::site();?>logout"><em><?php echo Kohana::lang('ui_admin.logout');?></em></a></li>

				</ul>

			<?php } else { ?>
				<a href="<?php echo url::site('login');?>" style="float:right;padding-top:8px;"><span class="header_nav_label"><strong><?php echo Kohana::lang('ui_main.login'); ?></strong></span></a>

				<ul class="header_nav_dropdown" style="display:none;">

					<?php echo form::open('login/', array('id' => 'userpass_form')); ?>
					<input type="hidden" name="action" value="signin">

					<li><label for="username"><?php echo Kohana::lang('ui_main.email');?></label><input type="text" name="username" id="username" class="login_text" /></li>

					<li><label for="password"><?php echo Kohana::lang('ui_main.password');?></label><input name="password" type="password" class="login_text" id="password" size="20" /></li>

					<li><input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.login'); ?>" class="header_nav_login_btn" /></li>
					<?php echo form::close(); ?>

					<li><hr/></li>

					<li><a href="<?php echo url::site()."login/?newaccount";?>"><?php echo Kohana::lang('ui_main.login_signup_click'); ?></a></li>

					<li><a href="#" id="header_nav_forgot" onclick="return false"><?php echo Kohana::lang('ui_main.forgot_password');?></a>

						<?php echo form::open('login/', array('id' => 'header_nav_userforgot_form')); ?>
						<input type="hidden" name="action" value="forgot">

						<label for="resetemail"><?php echo Kohana::lang('ui_main.registered_email');?></label>
						<input type="text" id="resetemail" name="resetemail" value="" />

						<input type="submit" id="submit" name="submit" value="<?php echo Kohana::lang('ui_main.reset_password'); ?>" class="header_nav_login_btn" />

						<br/>

						<?php echo form::close(); ?>

					</li>

				</ul>

			<?php } ?>


        </div><!--userdata-->
    </div><!--userinfodrop-->
</div><!--right-->


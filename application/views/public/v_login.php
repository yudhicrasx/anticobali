<?php			
			$attributes = array(
				'class'		=>'form-signin'
			);
			echo form_open('admin/login',$attributes);
			echo '<h1>Please sign in</h1>';
			
			$attributes_email = array(
				'name'        => 'email',
				'id'          => 'email',
				'value'       => set_value('email'),
				'maxlength'   => '128',
				'placeholder' => 'Email address',
				'class'		  => 'input-block-level'
			);
			echo form_input($attributes_email);
			
			$attributes_password = array(
				'name'        => 'password',
				'id'          => 'password',
				'maxlength'   => '128',
				'placeholder' => 'Password',
				'class'		  => 'input-block-level'
			);
			echo form_password($attributes_password);
			
			$attributes_submit = array(
				'id'	=> 'submit_button',
				'type'	=> 'submit',
				'name'	=> 'submit', 
				'class' => 'btn btn-large btn-primary'
			);
			echo form_button($attributes_submit, 'Login');
			
			echo form_close();
?>

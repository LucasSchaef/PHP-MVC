<div class="container-fluid">
	<div class="panel panel-default">
    	<div class="panel-heading">Details for User "<?php echo $this->userInfo['user_name']; ?>"</div>
        <div class="panel-body">
        	<table class="user-details">
            	<tr>
                	<td><strong>Username:</strong></td>
                    <td><?php echo $this->userInfo['user_name']; ?></td>
        		</tr>
                <tr>
                	<td><strong>E-Mail:</strong></td>
                    <td><?php echo '<a href="mailto:'.$this->userInfo['user_email'].'">'.$this->userInfo['user_email'].'</a>'; ?></td>
            	</tr>
                <tr>
                	<td><strong>Signed up since:</strong></td>
                    <td><?php echo date("F d, Y - h:i A", $this->userInfo['user_registration']); ?></td>
                </tr>
                <tr>
                	<td><strong>Last active:</strong></td>
                    <td><?php echo date("F d, Y - h:i A", $this->userInfo['user_last_active']); ?></td>
            	</tr>
        	</table>
        </div>
    </div>
</div>
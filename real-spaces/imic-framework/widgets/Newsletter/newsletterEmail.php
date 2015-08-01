<?php $Newsletter=get_option('NewsletterEmail');?>
<h1><?php _e('Email For Newsletter','framework');?></h1>
<table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>
        <th class="check-column" scope="row"></th>
        <th class="column-columnname"><?php  _e('Serial','framework'); ?></th>
        <th class="column-columnname"><?php  _e('Email Id','framework'); ?></th>
        <th class="column-columnname"><?php  _e('On Date','framework'); ?></th>
    </tr>
    </thead>
    <tbody>
        <?php 
        if(!empty($Newsletter)){
		$serial = 1;
        foreach($Newsletter as $key=>$value){ ?>
        <tr>
            <th class="check-column" scope="row"></th>
            <td class="column-columnname"><?php echo $serial; ?></td>
            <td class="column-columnname"><?php echo $key; ?></td>
            <td class="column-columnname"><?php echo $value; ?></td>
        </tr>
        <?php $serial++; }}else{ ?>
            <tr>
            <th class="check-column" scope="row"></th>
            <th class="column-columnname"><?php  _e('There is no Emails','framework'); ?></th>
            
        </tr>
        <?php } ?>
    </tbody>
</table>
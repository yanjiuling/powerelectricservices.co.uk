<?php global $fields, $tr_page?>
<form name="contactForm" method="post" action="" id="contactForm">
	<input type="hidden" name="form" value="contact"/>
	<input type="hidden" name="type" value="contact"/>
	<input type="hidden" name="permalink" value="<?=getCurrentURL()?>"/>
	
	<?php
	if(isset($tr_page))
	{
		?>
		<input type="hidden" name="origin" value="<?= $tr_page->title; ?>"/>
		<?php
	}
	?>
	<label>Name</label><br/><input type="text" name="name" style="width:100%;" value="<?=isset($fields['name']) ? $fields['name'] : ''?>"><br/>
	<label>Email</label><br/><input type="text" name="email" style="width:100%;" value="<?=isset($fields['email']) ? $fields['email'] : ''?>"><br/>
    <label>Phone number</label><br/><input type="text" name="phone" style="width:100%;" value="<?=isset($fields['phone']) ? $fields['phone'] : ''?>"><br/><br/>
    <label>Message</label><br/><textarea name="message" rows="10" cols="30" style="width:100%;"><?=isset($fields['message']) ? $fields['message'] : ''?></textarea>
    <br/><input id="submit" class="button" type="submit" name="submit" value="Send" />

</form>
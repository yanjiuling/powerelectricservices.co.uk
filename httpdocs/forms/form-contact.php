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
	<label for="cont_name">Name <span class="required-marker">*</span></label>
	<input type="text" name="name" size="26" id="cont_name" value="<?= isset($fields['name'])?$fields['name']:''; ?>">

	<label for="cont_addr">Address</label>
	<textarea name="address" cols="24" rows="5" id="address"><?= isset($fields['address'])?$fields['address']:''; ?></textarea>

	<label for="cont_phone">Telephone <span class="required-marker">*</span></label>
	<input type="text" name="phone" size="26" id="cont_phone" value="<?= isset($fields['phone'])?$fields['phone']:''; ?>">

	<label for="cont_email">Email <span class="required-marker">*</span></label>
	<input type="text" name="email" size="26" id="cont_email" value="<?= isset($fields['email'])?$fields['email']:''; ?>">

	<input type="submit" name="submit" class="button" value="Submit">

</form>
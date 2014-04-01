<?php global $fields, $tr_page?>
<form id="contactForm2" action="" method="post" name="contactForm2">
   	<input type="hidden" name="form" value="enquiry"/>
   	<input type="hidden" name="type" value="contact"/>
   	<input type="hidden" name="origin" value="<?= $tr_page->title; ?>"/>
	<input type="hidden" name="permalink" value="<?=getCurrentURL()?>"/>   	

    <label for="enqname">Name<span class="required-marker">*</span></label>
    <input type="text" id="enqname" size="26" name="name" value="<?= isset($fields['name'])?$fields['name']:''; ?>">

    <label for="enqemail">Email<span class="required-marker">*</span></label>
	<input type="text" id="enqemail" size="26" name="email" value="<?= isset($fields['email'])?$fields['email']:''; ?>">

    <label for="enqenquiry">Nature of enquiry<span class="required-marker">*</span></label>
    <textarea id="enqenquiry" rows="5" cols="24" name="enquiry"><?= isset($fields['enquiry'])?$fields['enquiry']:''; ?></textarea>

	<?php
	$query = "SELECT * FROM people_offices
		      ORDER BY off_name";
	$result = dbQuery($query);
	if(dbRows($result)>0)
	{
		?>
		<label class="whatbranchLabel">Preferred office: </label>
			<select id="whatbranch" name="whatbranch">
        	<option value="">No preference</option>
        	<?php
			while($row = dbAssoc($result))
			{
				extract($row);
				?>
				<option value="<?=$off_name?>" <?=isset($fields['enquiry']) && $off_name == $fields['enquiry'] ? 'selected="selected"' : ''?>>
                    <?=$off_name?>
                </option>
				<?php
			}
			?>
			<option value="Other" <?=isset($fields['whatbranch']) && $fields['whatbranch'] == "Other" ? 'selected="selected"' : ''?>>
            	Other
        	</option>
		</select>
		<?php
	}
	?>

<input type="submit" class="button" name="submit" value="Submit">

</form>

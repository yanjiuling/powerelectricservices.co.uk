<div id="footer">
	<div class="container">

	<?= buildMenu('mainNav',0,'',0,1,'',true,'','foot-nav'); ?>
    
	<?= serviceNav("foot-nav"); ?>
    
    <?php
    include_once(SRV_ROOT."admin/extensions/testimonials/functions.php");
    $query = "SELECT tst_id FROM testimonials WHERE tst_active = '1' ORDER BY RAND() LIMIT 1";
    $result = dbQuery($query);
    if(dbRows($result)>0)
    {
    	while($row = dbAssoc($result))
    	{
    		$tst = new testimonial($row['tst_id']);
    		?>
    		<div class="quote">
	    		<blockquote><p><span class="quotation open">"</span> <?=$tst->quote?> <span class="quotation close">"</span></p></blockquote>
	    		<p class="quote-author">
	    			<?php if($tst->url !='') echo '<a href="'.$tst->url.'">'; ?>
	    			<?=$tst->author?>
	    			<?php if($tst->url !='') echo '</a>'; ?>
	    		</p>
	    	</div>
    		<?php
    	}
    }
    ?>
    
    <div class="copy">
    	<?= $globalSettings['footer_text']?>
    </div>
    
</div>
</div><!--footer-->

<?= $globalSettings['tracker_code']?>
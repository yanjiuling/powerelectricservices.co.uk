<div class="header">
	<div class="container">
    	
        <div id="logo"></div><!--end logo-->
        
    	<header id="banner" role="banner">
            <div id="banner-inner-wrapper">
                <div id="banner-inner">
                   
                    <nav id="menu-nav">
                        <div id="menu-button">
                            <div id="menu-button-inner"></div>
                        </div>
                    </nav>
                </div>
            </div>
            <nav id="menu">
	        	<?= buildMenu('mainNav',0,'',0,1,'',true,'',''); ?>
	        </nav>
          
   		 </header>
   		 <div id="test">
         	<div id="telephone"><p>Call us on <?=$globalSettings['main_phone']?></p></div>
         	<div class="socnet">
	         	<?php
	         	if($globalSettings['twitter_url'].$globalSettings['facebook_url'] !='')
	         	{
	         		?>
	         		<p><span>Follow us</span>
	         		<?php
		         	if($globalSettings['twitter_url'] !='')
		         	{
		         		?>
		         		<a class="icon twitter" href="<?=$globalSettings['twitter_url']?>" target="_blank">Twitter</a>
		         		<?php
		         	}
		         	if($globalSettings['facebook_url'] !='')
		         	{
		         		?>
		         		<a class="icon facebook" href="<?=$globalSettings['facebook_url']?>" target="_blank">Facebook</a>
		         		<?php
		         	}
				 	?> 
	         		</p>
	         		<?php
	         	}
	         	?>  
         	</div>
         </div> 
         
         <div class="clear"></div>
                         
    </div><!--container-->
</div><!--.header-->
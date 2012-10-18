<div class="centercontent">
    
        <div class="pageheader">
		<h1 class="pagetitle">TOOLS</h1>
            <ul class="hornav">
			<?php foreach ($main_tabs as $page => $tab_name): ?>
			<li>
				<a href="<?php echo url::site(); ?>admin/<?php echo $page; ?>" <?php if($this_page==$page) echo 'class="active"' ;?>><?php echo $tab_name; ?></a>
			</li>
			<?php endforeach; ?>
            </ul>
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper">	
			<div id="updates" class="subcontent"> 
                  <div class="notibar announcement">
					<a class="close"></a>
					<h3>Announcement</h3>
					<p>This can be an awesome announcement tool that we can use
					for the platform. Or you can just use it to let others know
						how awesome Jepchumba, Linda and Sharon are. </p>
				 <div> 
            </div>            
        </div><!--contentwrapper-->
 </div><!-- centercontent -->
    

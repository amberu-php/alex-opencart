<h3><?php echo $heading_title; ?></h3>
<div class="row">
		<?php if( !empty($blogs) ) { ?>		
			<?php foreach( $blogs as $key => $blog ) { $key = $key + 1;?>
			<div class="col-lg-<?php echo 12 / $cols;?> col-md-<?php echo 12 / $cols;?> col-sm-12 col-xs-12" >
					<div class="well">
							<div class="blog-header clearfix">
							<h4 class="blog-title">
								<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a>
							</h4>
							</div>
							<div class="blog-body">
								<?php if( $blog['thumb']  )  { ?>
								<a href="<?php echo $blog['link'];?>" class="readmore">
								<img class="img-responsive" src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" align="left"/>
								</a>								
								<?php } ?>
								</br>
								<div class="description">
										<?php $blog['description'] = strip_tags($blog['description']); ?>
										<?php echo utf8_substr( $blog['description'],0, 200 );?>...
								</div>
								<a href="<?php echo $blog['link'];?>" class="readmore"><?php echo $objlang->get('text_readmore');?></a>
							</div>	
						</div>
			</div>
			<?php } ?>		
		<?php } ?>	
 </div>

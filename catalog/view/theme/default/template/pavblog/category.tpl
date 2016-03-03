<?php echo $header; ?>
<div class="container">

  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		
		<div class="row">
		<!-- Tags from category -->
			<?php if (isset($lang_tags)) { ?>
			<?php if ($all_blogs) { ?>
			<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" >	
			<?php } else { ?>
			<div class="col-lg-7 col-md-7 col-sm-10 col-xs-12" >
			<?php } ?>			
				<div class="box-tag">
				<span class="tag-title"><?php echo $text_tags; ?></span>
			      <ul>
				  	<li><a href="<?php echo $refAll; ?>"><?php echo $text_all; ?></a></li>

			        <?php foreach ($lang_tags as $lang_tag) { ?>
			        <li><a href="<?php echo $lang_tag['href']; ?>"><?php echo $lang_tag['name']; ?></a></li>
			        <?php } ?>

			      </ul>
			    </div>
			    </div>
			    <?php } else { ?>
				<div class="col-lg-7 col-md-7 col-sm-10 col-xs-12" >
				</div>
			    <?php } ?>
		<!-- Tags from category END-->

    <?php if (!$all_blogs) { ?>
  	<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
    </div>
        <div class="col-lg-3 col-md-3 col-sm-9 col-xs-12">
          <select id="input-sort" class="form-control" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
			<?php echo $sorts['value']; ?>
       	  <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
	<?php } ?>	

		</div>
		</br>
		<!-- Start Div Content -->
			<div class="pav-header">
				<a class="rss" href="<?php echo $category_rss;?>"><span class="fa fa-rss text-warning"></span></a>	
			</div>  
			<div class="pav-category">
			<?php if (!$all_blogs) { ?>
					<?php if( !empty($children) ) { ?>
					<div class="row">
					<div class="col-sm-9">
						<h3><?php echo $objlang->get('text_children');?></h3>
					</div>
						<div class="children-wrap">
							<?php 
							$cols = (int)$config->get('children_columns');
							$count = count($children);
							if ($count = 2 || $cols > 2) $cols = 2;
							foreach( $children as $key => $sub )  { $key = $key + 1;?>
								<div class="col-lg-<?php echo round(12 / $cols);?> col-md-<?php echo round(12 / $cols);?> col-sm-6 col-xs-12">
									<div class="well">
										<h4>
										<a href="<?php echo $sub['link']; ?>" title="<?php echo $sub['title']; ?>"><?php echo $sub['title']; ?> (<?php echo $sub['count_blogs']; ?>)</a> 
										
										</h4>
										<?php if( $sub['thumb'] ) { ?>
										<div class="bthumb">
										<a href="<?php echo $sub['link']; ?>" title="<?php echo $sub['title']; ?>">
											<img class="img-responsive" src="<?php echo $sub['thumb'];?>"/>
										</a>
										</div>
										<?php } ?>
										<div class="sub-description">
										<?php echo $sub['description']; ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				<?php } ?>

					<div class="row">
						<?php
						$cols = $config->get('cat_columns_leading_blog');
						if( count($leading_blogs) ) { ?>
							<div class="leading-blogs clearfix">
								<?php foreach( $leading_blogs as $key => $blog ) { $key = $key + 1;?>
								<div class="col-lg-<?php echo round(12 / $cols);?> col-md-<?php echo round(12 / $cols);?> col-sm-12 col-xs-12">
								

									<div class="well">
									<?php if( $config->get('cat_show_title') ) { ?>

									<?php if( $config->get('cat_show_created') ) { ?>
											<div class="create">

									<?php echo rdate("d M Y",strtotime($blog['created']));?>
											
											</div>
											<?php } ?>	
										
										<div class="blog-body">
											<?php if( $blog['thumb'] && $config->get('cat_show_image') )  { ?>
											<div class="bthumb">
											<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>">
											<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" class="img-responsive"/>
											</a>
											</div>
											<?php } ?>
											
											<div class="blog-header">
												<h4 class="blog-title">	<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a></h4>
												<?php } ?>
											</div>

											<?php if( $config->get('cat_show_description') ) {?>
											<div class="description">
												<?php echo $blog['description'];?>
											</div>
											<?php } ?>
											<?php if( $config->get('cat_show_readmore') ) { ?>
											<a href="<?php echo $blog['link'];?>" class="btn btn-primary"><?php echo $objlang->get('text_readmore');?></a>
											<?php } ?>
										</div>

										<hr>
										<div class="blog-meta">
											<ul class="list-inline">
											  	<li><?php if( $config->get('blog_show_author') ) { ?>
												<span class="author"><b><?php echo $objlang->get("text_write_by");?></b> <?php echo $blog['author'];?></span>
												<?php } ?>
												</li>

												<li>
												<?php if( $config->get('blog_show_category') ) { ?>
												<span class="publishin">
													<b><?php echo $objlang->get("text_published_in");?></b>
													<a class="color" href="<?php echo $blog['category_link'];?>" title="<?php echo $blog['category_title'];?>"><?php echo $blog['category_title'];?></a>
												</span>
												<?php } ?>	
												</li>
												<li>
												<?php if( $config->get('blog_show_hits') ) { ?>
												<span class="hits"><b><?php echo $objlang->get("text_hits");?></b> <?php echo $blog['hits'];?></span>
												<?php } ?>		
												</li>

												<li>
												<?php if( $config->get('blog_show_comment_counter') ) { ?>
												<span class="comment_count"><b><?php echo $objlang->get("text_comment_count");?></b> <?php echo $blog['comment_count'];?></span>
												<?php } ?>	
												</li>
											</ul>
										</div>
									</div>

								</div>
								<?php } ?>
							</div>
						<?php } ?>

						<?php
							$cols = $config->get('cat_columns_secondary_blogs');
							if ( count($secondary_blogs) ) { ?>
							<div class="secondary clearfix">
								
								<?php foreach( $secondary_blogs as $key => $blog ) {  $key = $key+1; ?>
								<div class="col-lg-<?php echo round(12 / $cols);?> col-md-<?php echo round(12 / $cols);?> col-sm-12 col-xs-12">
								


								<div class="well">
								<?php if( $config->get('cat_show_title') ) { ?>

								<?php if( $config->get('cat_show_created') ) { ?>
										<div class="create">

								<?php echo rdate("d M Y",strtotime($blog['created']));?>
										
										</div>
										<?php } ?>	
									
									<div class="blog-body">
										<?php if( $blog['thumb'] && $config->get('cat_show_image') )  { ?>
										<div class="bthumb">
										<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>">
										<img src="<?php echo $blog['thumb'];?>" title="<?php echo $blog['title'];?>" class="img-responsive"/>
										</a>
										</div>
										<?php } ?>
										
										<div class="blog-header">
											<h4 class="blog-title">	<a href="<?php echo $blog['link'];?>" title="<?php echo $blog['title'];?>"><?php echo $blog['title'];?></a></h4>
											<?php } ?>
										</div>

										<?php if( $config->get('cat_show_description') ) {?>
										<div class="description">
											<?php echo $blog['description'];?>
										</div>
										<?php } ?>
										<?php if( $config->get('cat_show_readmore') ) { ?>
										<a href="<?php echo $blog['link'];?>" class="btn btn-primary"><?php echo $objlang->get('text_readmore');?></a>
										<?php } ?>
									</div>

									<hr>
									<div class="blog-meta">
										<ul class="list-inline">
										  	<li><?php if( $config->get('blog_show_author') ) { ?>
											<span class="author"><b><?php echo $objlang->get("text_write_by");?></b> <?php echo $blog['author'];?></span>
											<?php } ?>
											</li>

											<li>
											<?php if( $config->get('blog_show_category') ) { ?>
											<span class="publishin">
												<b><?php echo $objlang->get("text_published_in");?></b>
												<a class="color" href="<?php echo $blog['category_link'];?>" title="<?php echo $blog['category_title'];?>"><?php echo $blog['category_title'];?></a>
											</span>
											<?php } ?>	
											</li>
											<li>
											<?php if( $config->get('blog_show_hits') ) { ?>
											<span class="hits"><b><?php echo $objlang->get("text_hits");?></b> <?php echo $blog['hits'];?></span>
											<?php } ?>		
											</li>

											<li>
											<?php if( $config->get('blog_show_comment_counter') ) { ?>
											<span class="comment_count"><b><?php echo $objlang->get("text_comment_count");?></b> <?php echo $blog['comment_count'];?></span>
											<?php } ?>	
											</li>
										</ul>
									</div>
								</div>


								</div>
								<?php } ?>
							</div>
						<?php } ?>
						<?php if( $total ) { ?>	
						<div class="pav-pagination pagination"><?php echo $pagination;?></div>
						<?php } ?>
					</div>
			</div>	
		
		<?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<?php
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    if(strpos($param,'M')===false) return date($param, $time);
        else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
 ?>
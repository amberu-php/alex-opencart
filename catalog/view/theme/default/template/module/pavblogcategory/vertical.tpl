<h3><?php echo $heading_title; ?></h3>
<div id="blog-verticalmenu" class="box">
	
	<div class="box-content">
		<?php echo $tree;?>
	</div>
</div>
<script type="text/javascript">
$(document).ready( function(){
    $("#blog-verticalmenu [data-toggle='dropdown']").click(function(){ 
        if(!$(this).parent().hasClass('open') && this.href && this.href != '#'){
            window.location.href = this.href;
        }
    });
});
</script>
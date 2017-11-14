<div class="search-box">
	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
		<input placeholder="Поиск..." type="text" name="s" id="search" id="search" value="<?= get_search_query() ?>" >
		<input type="submit" id="searchsubmit" value="">
		<div class="clear"></div>
	</form>
</div>
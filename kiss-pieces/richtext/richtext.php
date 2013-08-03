<?php
namespace richtext;

function init(){
	d($_POST);
	form();
}

function form($action=''){
	?>
	<form method="post" action="<?php echo $action; ?>">
		<textarea name="page"></textarea>
		<input type="submit">
	</form>
	<?php
}
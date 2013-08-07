<?php
namespace richtext;

function init(){
	global $r;
	$p = $r['parameters'];

	form($p['action'], $p['content']);
}

function form($action='', $content=''){
	?>
	<form method="post" action="<?php echo $action; ?>">
		<textarea name="page"><?=$content?></textarea>
		<input type="submit">
		<input name="_method_delete" value="Deletar página" type="submit">
	</form>
	<?php
}
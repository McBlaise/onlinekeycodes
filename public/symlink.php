<?php 
// symlink('../storage/app/public', '../public/storage');
// echo "string";
if(symlink( '../public/storage', '../storage/app/public')){
	echo 'Linked!';
}
else{
	echo 'Fail!';
}

 ?>


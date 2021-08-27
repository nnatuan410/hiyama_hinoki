<?php require_once(dirname(__FILE__) . '/../../config/settings.php'); ?>
<?php
// 現在の階層を取得
$path = str_replace(_ROOT_DIRECTORY_, '',  parse_url($_SERVER['REQUEST_URI'])['path']);
$path_arr = explode('/', trim($path, '/'));
if (count($path_arr) === 1 && $path_arr[0] === '') $path_arr = array();
$path_depth = count($path_arr); // 階層深さ
?>
<!-- <script src="<?php echo _ROOT_DIRECTORY_; ?>/common/js/viewport.min.js" defer></script> -->

<!-- <header id="header">

</header> -->



<?php include(dirname(__FILE__) . '/gnavi.php');

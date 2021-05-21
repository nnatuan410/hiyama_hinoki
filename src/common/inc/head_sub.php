<?php require_once(dirname(__FILE__) . '/../../config/settings.php'); ?>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_DIRECTORY_; ?>/common/css/common.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_DIRECTORY_; ?>/common/css/sub.min.css">
<?php if (_DEVELOP_MODE_) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_DIRECTORY_; ?>/common/css/develop.min.css">
<?php endif; ?>
<script>
	const ROOT_DIRECTORY = '<?php echo _ROOT_DIRECTORY_; ?>';
</script>
<script src="<?php echo _ROOT_DIRECTORY_; ?>/lib/js/pf.intrinsic.min.js" defer></script>
<script src="<?php echo _ROOT_DIRECTORY_; ?>/lib/js/picturefill.min.js" defer></script>

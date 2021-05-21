<?php require_once(dirname(__FILE__) . '/../../config/settings.php'); ?>
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_DIRECTORY_; ?>/common/css/common.min.css">
<?php if (_DEVELOP_MODE_) : ?>
	<link rel="stylesheet" type="text/css" href="<?php echo _ROOT_DIRECTORY_; ?>/common/css/develop.min.css">
<?php endif; ?>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@700&display=swap" rel="stylesheet">
<script>
	const ROOT_DIRECTORY = '<?php echo _ROOT_DIRECTORY_; ?>';
</script>
<script>
	(function(d) {
		var config = {
				kitId: 'cqz6dob',
				scriptTimeout: 3000,
				async: true
			},
			h = d.documentElement,
			t = setTimeout(function() {
				h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
			}, config.scriptTimeout),
			tk = d.createElement("script"),
			f = false,
			s = d.getElementsByTagName("script")[0],
			a;
		h.className += " wf-loading";
		tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
		tk.async = true;
		tk.onload = tk.onreadystatechange = function() {
			a = this.readyState;
			if (f || a && a != "complete" && a != "loaded") return;
			f = true;
			clearTimeout(t);
			try {
				Typekit.load(config)
			} catch (e) {}
		};
		s.parentNode.insertBefore(tk, s)
	})(document);
</script>
<script src="<?php echo _ROOT_DIRECTORY_; ?>/lib/js/pf.intrinsic.min.js" defer></script>
<script src="<?php echo _ROOT_DIRECTORY_; ?>/lib/js/picturefill.min.js" defer></script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<jdoc:include type="head" />
		<link href="themes/<?= $this->template ?>/css/<?= $this->template ?>.css" media="screen" rel="stylesheet" type="text/css" />

		<script src="themes/<?= $this->template ?>/js/mootools-core-1.4.2-full-nocompat.js" type="text/javascript"></script>
		<script src="themes/<?= $this->template ?>/js/<?= $this->template ?>.js" type="text/javascript"></script>
		
	</head>
	<body>
		<jdoc:include type="message" />
		<jdoc:include type="component" name="main" />
	</body>
</html>
<!-- Header -->
<?php echo $this->getHtml()->contentType(); ?>
<?php echo $this->getHtml()->meta('width=device-width, initial-scale=1.0', '', 'viewport'); ?>
<?php echo $this->getHtml()->meta('', '', 'description'); ?>
<?php echo $this->getHtml()->meta('', '', 'author'); ?>
<title>Trotri</title>

<!-- Bootstrap core CSS -->
<?php echo $this->getHtml()->cssFile($this->base_url . '/static/css/bootstrap.min.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->base_url . '/static/css/bootstrap-theme.min.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->base_url . '/static/js/bootstrap-switch/bootstrap-switch.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->base_url . '/static/js/jquery-icheck/square-blue.css?v=' . $this->version); ?>

<!-- Custom styles for this template -->
<?php echo $this->getHtml()->cssFile($this->base_url . '/static/css/template.css?v=' . $this->version); ?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/js/jquery-2.0.3.min.js'); ?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <?php echo $this->getHtml()->jsFile($this->base_url . '/static/js/assets/html5shiv.js'); ?>
  <?php echo $this->getHtml()->jsFile($this->base_url . '/static/js/assets/respond.min.js'); ?>
<![endif]-->
<!-- /Header -->

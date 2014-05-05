<!-- Header -->
<?php echo $this->getHtml()->contentType(); ?>
<?php echo $this->getHtml()->meta('IE=edge', 'X-UA-Compatible', ''); ?>
<?php echo $this->getHtml()->meta('width=device-width, initial-scale=1.0', '', 'viewport'); ?>
<?php echo $this->getHtml()->meta('', '', 'description'); ?>
<?php echo $this->getHtml()->meta('', '', 'author'); ?>
<title>Trotri</title>

<!-- Bootstrap core CSS -->
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/css/bootstrap.min.css'); ?>

<!-- Bootstrap theme CSS -->
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/css/bootstrap-theme.min.css'); ?>

<!-- Bootstrap-switch CSS -->
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/bootstrap-switch/bootstrap-switch.min.css'); ?>

<!-- Jquery-icheck CSS -->
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/jquery-icheck/skins/square/blue.css'); ?>

<!-- jQuery JS -->
<?php echo $this->getHtml()->cssFile($this->static_url . '/js/jquery-1.11.0.min.js'); ?>

<!-- Custom styles for this template -->
<?php echo $this->getHtml()->cssFile($this->css_url . '/template.css?v=' . $this->version); ?>

<script type="text/javascript">
var g_url = "<?php echo $this->script_url; ?>"; var g_uri = "<?php echo $this->request_uri; ?>"; var g_logId = "<?php echo $this->log_id; ?>";
var g_mod = "<?php echo $this->module; ?>"; var g_ctrl = "<?php echo $this->controller; ?>"; var g_act = "<?php echo $this->action; ?>";
</script>

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/js/ie8-responsive-file-warning.js'); ?><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/js/html5shiv.min.js'); ?>
  <?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/js/respond.min.js'); ?>
<![endif]-->

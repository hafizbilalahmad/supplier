<html>
    <head>
        <title><?= $title ?></title>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>" />
        <link rel="stylesheet" href="<?php echo base_url('assets/css/common.css'); ?>" />

    </head>
    <body>
        <div class="continer">
            <input type="hidden" name="my_site_url" id="my_site_url" value="<?= site_url();?>">
            <input type="hidden" name="my_base_url" id="my_base_url" value="<?= base_url();?>">

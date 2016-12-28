<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>卓软社</title>
    <link rel="stylesheet" href="<?php echo base_url('/public/bootstrap/css/bootstrap.min.css'); ?>">
    <script src="<?php echo base_url('/public/bootstrap/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('/public/bootstrap/js/bootstrap.min.js'); ?>"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <?php echo html_entity_decode($news_content); ?>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $('img').addClass('img-responsive');
    });

</script>
</html>
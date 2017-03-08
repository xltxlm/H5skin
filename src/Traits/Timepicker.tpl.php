<?php /** @var \xltxlm\h5skin\Traits\Timepicker $this */ ?>
<!-- js 插件官网地址 http://timepicker.co/ -->
<link rel="stylesheet" href="/static/css/jquery.timepicker.min.css">
<script src="/static/js/jquery.timepicker.min.js"></script>
<script>
    $('.<?=$this::getTimepickerCss()?>').timepicker({
        timeFormat: 'HH:mm',
        interval: <?=$this->getInterval()?>,
        minTime: '<?=$this->getMinTime()?>',
        maxTime: '<?=$this->getMaxTime()?>',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
</script>

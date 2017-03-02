<?php
/** @var \kuaigeng\abconfig\vendor\xltxlm\h5skin\src\Traits\DatePicker $this */
use \kuaigeng\abconfig\vendor\xltxlm\h5skin\src\Traits\DatePicker;

?>
<script src="/static/js/moment.min.js"></script>
<script src="/static/js/daterangepicker.min.js"></script>
<link href="/static/css/daterangepicker.min.css" rel="stylesheet">
<script>
    $(function () {
        var id = ".<?=DatePicker::daterangepicker()?>";
        $(id).daterangepicker({
            timePicker: <?=$this->isTimePicker()?>,
            autoUpdateInput: false,
            locale: {
                format: '<?=$this->getFormat()?>'
            }
        });

        $(id).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('<?=$this->getFormat()?>') + ' - ' + picker.endDate.format('<?=$this->getFormat()?>'));
        });

        $(id).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
</script>
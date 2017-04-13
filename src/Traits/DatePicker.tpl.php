<?php
/** @var \xltxlm\h5skin\Traits\DatePicker $this */
use xltxlm\h5skin\Traits\DatePicker;

?>
<script src="/static/js/moment.min.js"></script>
<script src="/static/js/daterangepicker.min.js"></script>
<link href="/static/css/daterangepicker.min.css" rel="stylesheet">
<script>
    $(function () {
        var id = ".<?=DatePicker::daterangepicker()?>";
        $(id).daterangepicker({
            timePicker: <?=$this->isTimePicker()?>,
            singleDatePicker:<?=$this->isSingleDatePicker()?>,
            autoUpdateInput: false,
            locale: {
                format: '<?=$this->getFormat()?>'
            }
        });

<?php if($this->isSingleDatePicker()=='false') {?>
        $(id).on('apply.daterangepicker', function (ev, picker) {
            var val=picker.startDate.format('<?=$this->getFormat()?>') + ' - ' + picker.endDate.format('<?=$this->getFormat()?>');
            $(this).val(val);
        });
<?php }else{?>
        $(id).on('apply.daterangepicker', function (ev, picker) {
            var val=picker.startDate.format('<?=$this->getFormat()?>');
            $(this).val(val);
        });
<?php }?>
        $(id).on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
</script>
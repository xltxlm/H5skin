<?php
if (!defined(__FILE__)) {
    ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <script src="/static/js/select2.min.js"></script>
    <script>
        //单选下拉框
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
    </script>

    <script src="/static/js/jquery.sumoselect.min.js"></script>
    <link href="/static/css/sumoselect.css" rel="stylesheet" />
    <script>
        //多选下拉框
        $(function () {
            //Initialize Select2 Elements
            $(".sumoselect").SumoSelect({search: true, searchText: 'Enter here.',placeholder: '请选择'});
        });
    </script>
    <?php
    define(__FILE__, true);
}
?>
<?php /** @var \xltxlm\h5skin\SelectTPL $this */ ?>
<select class="<?= $this->getClassName() ?> <?= $this->isMultiple() ? 'sumoselect ' : 'select2' ?>"
        name="<?= $this->getName() ?>" <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?> id="<?= $this->getId() ?>"
    <?= $this->isMultiple() ? ' multiple="multiple" ' : '' ?>
        title="<?= $this->getName() ?>">
    <?php foreach ($this->getOptions() as $showText => $value) { ?>
        <option value="<?= $value ?>"
                <?php if ($this->getDefault() == $value){ ?>selected<?php } ?>><?= $showText ?></option>
    <?php } ?>
</select>

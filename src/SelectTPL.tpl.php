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
    <link href="/static/css/sumoselect.css" rel="stylesheet"/>
    <script>
        //多选下拉框
        $(function () {
            //Initialize Select2 Elements
            $(".sumoselect").SumoSelect({search: true, searchText: 'Enter here.', placeholder: '请选择'});
        });
    </script>
    <?php
    define(__FILE__, true);
}
?>
<?php /** @var \xltxlm\h5skin\SelectTPL $this */ ?>
<select <?=join("  ",$this->getAttr())?> style="font-size:18px;" <?if($this->isQuick()){?>size="<?=count($this->getOptions())?>"<?php }?> class="<?= $this->getClassName() ?> <?= $this->isMultiple() ? 'sumoselect ' : ($this->isSelect2() ? 'select2' : '') ?>"
        name="<?= $this->getName() ?>" <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?> id="<?= $this->getId() ?>"
    <?= $this->isMultiple() ? ' multiple="multiple" ' : '' ?>
        title="<?= $this->getName() ?>">
    <?php $i=0; foreach ($this->getOptions() as $showText => $value) { $i++;?>
        <option value="<?= $value ?>" <?php if ($this->getDefault() == $value){ ?>selected<?php } ?>><?if($this->isQuick()){ echo $i;}?><?= $showText ?></option>
    <?php } ?>
</select>

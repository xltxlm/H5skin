<?php
if (!defined(__FILE__)) {
    ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <script  src="/static/js/select2.min.js"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
    </script>
    <?php
    define(__FILE__, true);
}
?>
<?php /** @var \xltxlm\h5skin\SelectTPL $this */ ?>
<select class="<?= $this->getClassName() ?> select2"
        name="<?= $this->getName() ?>" <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?> id="<?= $this->getId() ?>"
        title="<?= $this->getName() ?>">
    <?php foreach ($this->getOptions() as $showText => $value) { ?>
        <option value="<?= $value ?>"
                <?php if ($this->getDefault() == $value){ ?>selected<?php } ?>><?= $showText ?></option>
    <?php } ?>
</select>

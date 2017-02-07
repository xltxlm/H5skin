<?php /** @var \xltxlm\h5skin\SelectTPL $this */ ?>
<select class="<?=$this->getClassName()?>" name="<?= $this->getName() ?>"  <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?>  id="<?= $this->getId() ?>" title="<?= $this->getName() ?>">
    <?php foreach ($this->getOptions() as $showText => $value) { ?>
        <option value="<?= $value ?>"
                <?php if ($this->getDefault() == $value){ ?>selected<?php } ?>><?= $showText ?></option>
    <?php } ?>
</select>

<?php /** @var \xltxlm\h5skin\OptionTPL $this */?>
<div class="form-group" >
    <?php foreach ($this->getOptions() as $showText => $value) { ?>
    <label>
        <input type="radio" name="<?=$this->getName()?>" value="<?=$value?>"  <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?> <?php if($this->getDefault()==$value){ ?>checked<?php }?> >
        <?=$showText?>
    </label>
    <?php } ?>
</div>
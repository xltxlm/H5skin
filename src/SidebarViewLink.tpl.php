<?php /** @var  \xltxlm\H5skin\SidebarViewLink $this */
?>
<li class="<<?= '?' ?>= in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>) ? 'active' : '' <?= '?' ?>>">
    <a href="<<?= '?' ?>= call_user_func([<?= $this->getClassName() ?>::class, 'urlNoFollow'], json_decode('<?= json_encode($this->getArgs(), JSON_UNESCAPED_UNICODE) ?>',true)) <?= '?' ?>>">
        <<?= '?' ?>php if (in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>)) { <?= '?' ?>>
            <i class="fa fa-circle-o text-red"></i>
            <<?= '?' ?>php } else { <?= '?' ?>>
                <i class="fa fa-th"></i>
                <<?= '?' ?>php } <?= '?' ?>>
                    <span><?= $this->getName() ?></span>
    </a>
</li>

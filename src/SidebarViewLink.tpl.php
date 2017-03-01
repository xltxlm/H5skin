<?php /** @var  \xltxlm\h5skin\SidebarViewLink $this */
?>
<li class="<<?= '?' ?>= (!$_GET['class'] && in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>) || ($_GET['class'] && $_GET['class'] == '<?=$this->getArgs()['class']?>') ) ? 'active' : '' <?= '?' ?>>">
    <a href="<<?= '?' ?>= call_user_func([<?= $this->getClassName() ?>::class, 'urlNoFollow'], json_decode('<?= json_encode($this->getArgs(), JSON_UNESCAPED_UNICODE) ?>',true)) <?= '?' ?>>">
        <<?= '?' ?>php if ( !$_GET['class'] && in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>)  || ($_GET['class'] && $_GET['class'] == '<?=$this->getArgs()['class']?>') ) { <?= '?' ?>>
            <i class="fa fa-circle-o text-red"></i>
            <<?= '?' ?>php } else { <?= '?' ?>>
                <i class="fa fa-th"></i>
                <<?= '?' ?>php } <?= '?' ?>>
                    <span><?= $this->getName() ?></span>
    </a>
</li>

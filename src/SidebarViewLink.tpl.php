<?php /** @var  \xltxlm\h5skin\SidebarViewLink $this */
$className = $this->getClassName();
if($this->getLockDomain()){
?>
<?='<'?>?php
if(in_array($_SERVER['HTTP_HOST'],<?=json_encode($this->getLockDomain(),JSON_UNESCAPED_UNICODE)?>))
{
    \xltxlm\helper\Util::d($_SERVER['HTTP_HOST']);
?>
<?php }?>
<li class="<<?= '?' ?>= in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>) ? 'active' : '' <?= '?' ?>>">
    <a href="<<?= '?' ?>= call_user_func([<?= $this->getClassName() ?>::class, 'urlNoFollow'], json_decode('<?= json_encode($this->getArgs(), JSON_UNESCAPED_UNICODE) ?>',true)) <?= '?' ?>>">
        <<?= '?' ?>php if (in_array(LoadClass::$runClass,<?= json_encode($this->getHighlightClass(), JSON_UNESCAPED_UNICODE) ?>)) { <?= '?' ?>>
            <i class="fa fa-circle-o text-red"></i>
            <<?= '?' ?>php } else { <?= '?' ?>>
                <i class="fa fa-th"></i>
                <<?= '?' ?>php } <?= '?' ?>>
                    <span><?= $this->getName()?:(new $className)->getTitle() ?></span>
    </a>
</li>

<?php if($this->getLockDomain()){ ?>
<?='<'?>?php }?>
<?php }?>
<?php /** @var  \xltxlm\h5skin\component\Itime $this */
if (!defined(__FILE__)) {
    $vueid = md5(get_class($this));
    define(__FILE__, true);
?>
<script  src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/iTime/iTime.js" ></script>
<?php }
if ($this->isInit()) {
    return false;
} ?>

<itime <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>"></itime>


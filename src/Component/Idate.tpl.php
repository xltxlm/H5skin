<?php /** @var \xltxlm\h5skin\component\Idate $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script  src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/Idate/Idate.js" ></script>
<?php } if($this->isInit()){ return false;}?>

<idate <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :fulldate="<?=$this->isFulldate()?'true':'false'?>" :timeago="<?=$this->isTimeAgo()?'true':'false'?>" ></idate>

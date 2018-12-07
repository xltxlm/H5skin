<?php /** @var \xltxlm\h5skin\component\Iinput $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getPort()?>/Vue/Iinpit/Iinputconfirm.js?t=<?=date('Ymd')?>" ></script>

<?php } if($this->isInit()){ return false;}?>
<iinputconfirm <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>"  :showfield="<?=$this->isShowfield()?'true':'false'?>" <?php if($this->getItem()){?>:item="<?=$this->getItem()?>"<?php }?> greenvalue="<?=$this->getGreenvalue()?>"  redvalue="<?=$this->getRedvalue()?>" :allwaysopen="<?=$this->isAllwaysopen()?'true':'false'?>" ></iinputconfirm>


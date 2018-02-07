<?php /** @var  \xltxlm\h5skin\component\Iselect $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="application/javascript" src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/iSelect/iselecttag.js" ></script>
<script type="application/javascript" src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/iSelect/iSelect.js" ></script>


<?php } if($this->isInit()){ return false;}?>

<iselect <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" <?php if($this->getOption()){?>:option='<?=$this->getOption()?>'<?php }?> :multiple="<?=$this->isMultiple()?'true':'false'?>" :addTag="<?=$this->isAddTag()?'true':'false'?>" :tag="<?=$this->isTag()?'true':'false'?>" :optionvalues='<?=$this->getOptionValues()?>' <?php if($this->getOptionajax()){?>:optionajax="<?=$this->getOptionajax()?>"<?php }?> ></iselect>

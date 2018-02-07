<?php /** @var  \xltxlm\h5skin\component\Power $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="application/javascript" src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/iPower/iPower.js" ></script>
<?php  } if($this->isInit()){ return false;}?>
<ipower power="<?=$this->getPower()?>"  ajaxediturl="<?=$this->getAjaxEditUrl()?>" ctroller="<?=$this->getCtroller()?>" ></ipower>

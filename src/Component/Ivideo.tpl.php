<?php /** @var \xltxlm\h5skin\Component\Ivideo $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script  src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getPort()?>/Vue/iVideo/iVideo.js?t=<?=date('Ymd')?>" ></script>
<?php } if($this->isInit()){ return false;}?>
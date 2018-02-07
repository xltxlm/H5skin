<?php /** @var \xltxlm\h5skin\Component\Ivideo $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="application/javascript" src="https://<?=$this->getSsoThrift()->getHosturl()?>:<?=$this->getSsoThrift()->getHttpsport()?>/Vue/iVideo/iVideo.js" ></script>
<?php } if($this->isInit()){ return false;}?>
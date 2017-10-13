<?php /** @var \xltxlm\h5skin\Component\Ivideo $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <img v-if="!videomodel" v-lazy='this.pic' :key="this.id+'img'" :style="{width:this.picwidth+'px',height:this.picheight+'px'}"   @click="this.mousemove" >
        <video v-else controls="controls"  :key="this.id+'video'"  :id="'ivideo'+this.id"  :style="{width:this.picwidth+'px',height:this.picheight+'px'}"  :src='this.playurl' @click="pausevideo"  >
        </video>
    </div>
</script>


<script type="application/javascript">
    Vue.component("ivideo2",
        {
            template: "#c-<?=$vueid?>",
            data: function () {
                return {
                    videomodel:false,
                    waiting: true
                }
            },
            props: [
                'item',
                'id',
                'title',
                'playurl',
                'pic',
                'picwidth',
                'picheight'
            ],
            methods: {
                cancel:function () {
                    this.waiting = true;
                    this.videomodel=false;
                    var id='#ivideo'+this.id;
                    setTimeout(function () {
                        $(id)[0].pause();
                    },200)
                },
                mousemove: function () {
                    this.waiting = false;
                    this.videomodel=true;
                    var id='#ivideo'+this.id;
                    setTimeout(function () {
                        $(id)[0].play();
                    },200)
                },
                pausevideo: function () {
                    if (event.target.paused) {
                        event.target.play();
                    }else
                        event.target.pause();
                }
            }
        }
    );
</script>
<?php  } ?>
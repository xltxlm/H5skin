<?php /** @var \xltxlm\h5skin\Component\Ivideo $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div>
        <Tooltip content="单击播放视频">
            <img v-lazy='this.pic' :key="this.id+'img'" width='200px' @click="this.mousemove" ><br>
        </Tooltip>
        <Modal :key="this.id+'vod'"
                :scrollable="true"
                :styles="{top: '50px','left':'20px',width:'650px'}"
                v-model="videomodel"
                @on-cancel="cancel"
                @ok="cancel">
            <h3 v-text="this.title"></h3>
            <video v-if="videomodel" controls="controls"  :key="this.id+'video'"  :id="'ivideo'+this.id" style="max-width: 550px"  :src='this.playurl' >
            </video><br><br><br>
            <a :href="this.playurl" target="_blank">新窗口打开视频</a>
        </Modal>
    </div>
</script>


<script type="application/javascript">
    Vue.component("ivideo",
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
                'pic'
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
                playvideo: function () {
                    event.target.play();
                    event.target.width = '450'
                },
                pausevideo: function () {
                    event.target.pause();
                    event.target.width = '150'
                },
                control: function () {
                    event.target.controls = !event.target.controls;
                }
            }
        }
    );
</script>
<?php  } ?>
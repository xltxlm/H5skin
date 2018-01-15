<?php /** @var \xltxlm\h5skin\component\IcheckGroup $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<!--  options 格式是对象，id:"value"  -->
<script type="text/x-template"  id="c-<?=$vueid?>">
    <div>
        <Checkbox-group v-model="myhaschecked" :key="this.id" @input="updateValue"  style="display: inline" v-if="this.reshow">
            <Checkbox  v-for="(item,index) in myoptions"
                       :label="item.id"
                       :disabled="disabled"
                       @drop.native="drop(index,$event)"
                       @dragover.native="dragover"
                       draggable
                       @dragstart.native="dragstart(index,$event)"
                       @keyup.37.native="left"
                       @keyup.39.native="right"
                       @click.native="click(item.id,index)"
            >
                <Tooltip placement="top" content="可以拖住移动...." :always="this.moveid==item.id">
                    <span v-text="item.name"></span>
                </Tooltip>
            </Checkbox>
        </Checkbox-group>
        <a href="javascript:void(0)" class="btn bg-orange margin " @click="modaldialog = true" >重置</a>
        <a href="javascript:void(0)" class="btn bg-purple margin " @click="reload" >保存</a>
        <Modal
                v-model="modaldialog"
                @on-ok="reset"
                @on-cancel="cancel">
            <p>确认重置选项和排序规则</p>
        </Modal>
    </div>
</script>
<script type="application/javascript">
    Vue.component('icheckgroup',
        {
            template:"#c-<?=$vueid?>",
            data:function(){
                return {
                    disabled:false,		
                    modaldialog:false,
                    myoptions:this.options,
                    myhaschecked:this.haschecked,
                    tmpindex:0,
                    moveindex:0,
                    moveid:0,
                    //强制重绘元素
                    reshow:true
                };
            },
            props: [
                'options',
                'haschecked',
                'ajaxurl',
                'name',
                'value'
            ],
            methods:{
                click:function (id,index) {
                    if(index<1)
                    {
                        this.moveid='';
                        return;
                    }
                    this.moveindex=index;
                    this.moveid=id;

                },
                left:function () {
                   if(!this.moveid || this.moveindex<1 || this.moveindex>this.myoptions.length-1)
                    {
                        return;
                    }
                    var tmp = this.myoptions[this.moveindex];
                    //删除掉拽住的元素
                    this.myoptions.splice(this.moveindex, 1);
                    //被压的元素前面加 上 拽住的元素
                    this.myoptions.splice(this.moveindex-1, 0,tmp);
                    this.moveindex=this.moveindex-1;
                    this.reshow=false;
                    this.reshow=true;
                },
                right:function () {
                    if(!this.moveid || this.moveindex<0 || this.moveindex > this.myoptions.length-1)
                    {
                        return;
                    }
                    var tmp = this.myoptions[this.moveindex];
                    //删除掉拽住的元素
                    this.myoptions.splice(this.moveindex, 1);
                    //被压的元素前面加 上 拽住的元素
                    this.myoptions.splice(this.moveindex+1, 0,tmp);
                    this.moveindex=Math.min(this.myoptions.length-1,this.moveindex+1);
                    this.reshow=false;
                    this.reshow=true;
                },
                cancel:function () {
                    this.modaldialog=false;
                },
                updateValue: function () {
                    // 通过 input 事件发出数值
                    this.$emit('input', this.myhaschecked)
                },
                drop:function(index,event)
                {
                    this.disabled=false;
                    var tmp = this.myoptions[this.tmpindex];
                    //删除掉拽住的元素
                    this.myoptions.splice(this.tmpindex, 1);
                    //被压的元素前面加 上 拽住的元素
                    this.myoptions.splice(index, 0,tmp);
                },
                dragover:function()
                {
                    event.preventDefault();
                },
                dragstart:function(index,event)
                {
                    this.disabled=true;
                    this.tmpindex = index;
                },
                reset:function()
                {
                    this.myoptions=[];
                    this.myhaschecked=[];
                    this.modaldialog=false;
                    this.reload();
                },
                reload:function()
                {
                    window.location.reload();
                },
                updateSetingValue:function () {
                    eval('$.post(this.ajaxurl,{'+this.name+':{options:this.myoptions,checked:this.myhaschecked}});');
                }
            },
            watch: {
                myoptions:function(val)
                {
                    this.updateSetingValue();
                },
                myhaschecked:function(val)
                {
                    this.updateSetingValue();
                }
            }
        }
    );
</script>

<?php } ?>
<icheckgroup <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>"   name="<?=$this->getName()?>" :options='<?=$this->getOptions()?>' :haschecked='<?=$this->getHaschecked()=='null'?'[]':$this->getHaschecked()?>' ></icheckgroup>

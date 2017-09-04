<?php /** @var \xltxlm\h5skin\component\IcheckGroup $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<!--  options 格式是对象，id:"value"  -->
<script type="text/x-template"  id="c-<?=$vueid?>">
    <div>
        <Checkbox-group v-model="myhaschecked"  @input="updateValue"  style="display: inline">
            <Checkbox  v-for="(item,index) in myoptions"
                       :label="item.id"
                       @drop.native="drop(index,$event)"
                       @dragover.native="dragover"
                       draggable
                       @dragstart.native="dragstart(index,$event)"
            ><span v-text="item.name"></span></Checkbox>
        </Checkbox-group>
        <a href="javascript:void(0)" class="btn bg-orange margin " @click="reset" >重置</a>
        <a href="javascript:void(0)" class="btn bg-purple margin " @click="reload" >保存</a>
    </div>
</script>
<script type="application/javascript">
    Vue.component('icheckgroup',
        {
            template:"#c-<?=$vueid?>",
            data:function(){
                return {
                    myoptions:this.options,
                    myhaschecked:this.haschecked,
                    tmpindex:0
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
                updateValue: function () {
                    // 通过 input 事件发出数值
                    this.$emit('input', this.myhaschecked)
                },
                drop:function(index,event)
                {
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
                    this.tmpindex = index;
                },
                reset:function()
                {
                    this.myhaschecked=[];
                },
                reload:function()
                {
                    window.location.reload();
                }
            },
            watch: {
                myhaschecked:function(val)
                {
                    eval('$.get(this.ajaxurl,{'+this.name+':{options:this.myoptions,checked:this.myhaschecked}});');
                }
            }
        }
    );
</script>

<?php } ?>
<icheckgroup <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>"   name="<?=$this->getName()?>" :options='<?=$this->getOptions()?>' :haschecked='<?=$this->getHaschecked()=='null'?'[]':$this->getHaschecked()?>' ></icheckgroup>

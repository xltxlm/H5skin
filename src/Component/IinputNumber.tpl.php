<?php /** @var \xltxlm\h5skin\component\IinputNumber $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <span v-if="this.edit">
            <span v-if="editing==true">
                <InputNumber  v-model="this.value" :key="this.id+this.name"    @on-blur="updateValue(this.value)"  ></InputNumber>
                <br><a href="javascript:void(0)" @click="editing=false;">只读</a>
            </span>
            <span v-else><span v-text="this.value"></span><br><a href="javascript:void(0)" @click="editing=true;">编辑</a></span>
        </span>
        <span v-else>
            <span v-if="this.showfield" v-html="eval('window.'+this.name+'(value,this.item);')"></span>
            <span v-else v-text="value"></span>
        </span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("iinputnumber",
        {
            template:"#c-<?=$vueid?>",
            data:function()
            {
                return {
                    editing:false,
                    loading:false
                };
            },
            props:[
                'item',
                'showfield',
                'edit',
                'ajaxurl',
                'id',
                'name',
                'value'
            ],
            watch: {
                id:function () {
                    this.editing = false;
                }
            },
            methods:{
                updateValue: function (value) {
                    //this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        context:this,
                        url: this.ajaxurl,
                        data: {
                            'id':this.id,
                            'name':this.name,
                            'value':encodeURIComponent(value)
                        },
                        success: function (result) {
                            if(result.code!=0)
                            {
                                notyf.alert("修改失败!"+result.message);
                                return;
                            }
                            // 通过 input 事件发出数值
                            this.$emit('input', value);
                            vueel.$emit(this.name+'change', this.item,value,this.value);
                            this.$data.loading=false;
                            this.$data.editing=false;
                        },
                        error:function () {
                            notyf.alert("修改失败!");
                        }
                    });
                }
            }
        }
    );
</script>

<?php } if($this->isInit()){ return false;}?>

<iinputnumber <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :showfield="<?=$this->isShowfield()?'true':'false'?>" <?php if($this->getItem()){?>:item="<?=$this->getItem()?>"<?php }?>></iinputnumber>


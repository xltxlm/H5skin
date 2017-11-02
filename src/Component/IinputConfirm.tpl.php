<?php /** @var \xltxlm\h5skin\component\Iinput $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>

<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <span v-if="this.edit" >
            <span v-if="editing==true">
                <Spin v-if="this.loading" size="large"></Spin>
                <i-input  v-if="!this.loading" :name="this.name" type="textarea" :key="this.id+this.name" :id="this.id+'<?=$vueid?>'"  v-model="this.value" ></i-input>
                <button @click="updateValue($('#'+id+'<?=$vueid?> textarea').val())">提交</button>
                <br><a href="javascript:void(0)" @click="editing=false;">只读</a> <Spin v-if="ajax && ajaxing"></Spin><Icon v-if="ajax && !ajaxing" type="checkmark-circled" color="green"></Icon>
            </span>
            <span v-else><span v-text="this.value"></span><br><a href="javascript:void(0)" @click="editing=true;" >编辑</a></span>
        </span>
        <span v-else :class="{ 'badge bg-green':this.value && this.value==this.greenvalue, 'badge bg-red':this.value && this.value==this.redvalue }" >
                <span v-if="this.showfield" v-html="eval(this.name+'(value,this.item);')"></span>
                <span v-else v-text="value"></span>
        </span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("iinputconfirm",
        {
            template: "#c-<?=$vueid?>",
            data: function () {
                return {
                    ajaxing:false,
                    ajax:false,
                    editing: false,
                    rows: 1,
                    loading: false
                };
            },
            props: [
                'item',
                'edit',
                'showfield',
                'ajaxurl',
                'id',
                'class',
                'name',
                'value',
                'greenvalue',
                'redvalue'
            ],
            watch: {
                id:function () {
                    this.editing = false;
                }
            },
            methods:{
                updateValue: function (value) {
                    this.ajax=true;
                    this.ajaxing=true;
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
                            // 通过 input 事件发出数值
                            this.$emit('input', value);
                            this.$data.loading=false;
                            if(result.code!=0)
                            {
                                notyf.alert("修改失败!"+result.message);
                            }
                        },
                        error:function () {
                            notyf.alert("修改失败!");
                        },
                        complete:function () {
                            this.$data.ajaxing=false;
                            var vue=this;
                            setTimeout(function () {
                                vue.$data.ajax=false;
                            },1000)
                        }
                    });
                }
            }
        }
    );
</script>

<?php } if($this->isInit()){ return false;}?>
<iinputconfirm <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>"  :showfield="<?=$this->isShowfield()?'true':'false'?>" <?php if($this->getItem()){?>:item="<?=$this->getItem()?>"<?php }?> greenvalue="<?=$this->getGreenvalue()?>"  redvalue="<?=$this->getRedvalue()?>"></iinputconfirm>


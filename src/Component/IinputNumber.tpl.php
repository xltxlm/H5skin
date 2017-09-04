<?php /** @var \xltxlm\h5skin\component\IinputNumber $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <InputNumber v-if="this.edit" v-model="this.value" @input="updateValue"   ></InputNumber>
        <span v-else v-text="this.value"></span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("iinputnumber",
        {
            template:"#c-<?=$vueid?>",
            data:function()
            {
                return {
                    loading:false
                };
            },
            props:[
                'edit',
                'ajaxurl',
                'id',
                'name',
                'value'
            ],
            methods:{
                updateValue: function (value) {
                    //this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        context:this,
                        url: '<?=$this->getAjaxEditUrl()?>',
                        data: {
                            'id':this.id,
                            'name':this.name,
                            'value':encodeURIComponent(value)
                        },
                        success: function (result) {
                            // 通过 input 事件发出数值
                            this.$emit('input', value);
                            this.$data.loading=false;
                        }
                    });
                }
            }
        }
    );
</script>

<?php } ?>

<iinputnumber <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>"></iinputnumber>


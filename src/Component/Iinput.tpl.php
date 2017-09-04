<?php /** @var \xltxlm\h5skin\component\Iinput $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>

<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <span v-if="this.edit">
            <Spin v-show="this.loading" size="large"></Spin>
            <i-input  v-show="!this.loading" :name="this.name" type="textarea"  v-model="this.value" @on-blur="updateValue($event.target.value)"></i-input>
        </span>
        <span v-else >
                <span v-if="this.showfield" v-html="eval(this.name+'(value,this.item);')"></span>
                <span v-else v-text="value"></span>
        </span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("iinput",
        {
            template:"#c-<?=$vueid?>",
            data:function()
            {
              return {
                loading:false
              };
            },
            props:[
                'item',
                'edit',
                'showfield',
                'ajaxurl',
                'id',
                'name',
                'value'
            ],
            methods:{
                updateValue: function (value) {
                    //如果没有修改，那么不要提交
                    if(value == this.value)
                    {
                        return false;
                    }
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
<iinput <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>"  :showfield="<?=$this->isShowfield()?'true':'false'?>" <?php if($this->getItem()){?>:item="<?=$this->getItem()?>"<?php }?> ></iinput>


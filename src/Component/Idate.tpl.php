<?php /** @var \xltxlm\h5skin\component\Idate $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <input :id="'c-<?=$vueid?>-'+this.name" type="hidden" :name="this.name" value="">
        <span v-if="edit">
            <span v-if="editing==true">
                <Date-picker v-if="fulldate" type="datetime" format="yyyy-MM-dd HH:mm"  v-model="this.value"  @input="updateValue"  :key="this.id+this.name"   ></Date-picker>
                <Date-picker v-else type="datetime" format="yyyy-MM-dd"  v-model="this.value" @input="updateValue" :key="this.id+this.name"  ></Date-picker>
                <br><a href="javascript:void(0)" @click="editing=false;">只读</a>
            </span>
            <span v-else><span v-text="this.value"></span><br><a href="javascript:void(0)" @click="editing=true;">编辑</a></span>
        </span>
        <span v-else >
            <span :title="this.value" v-if="timeago" v-html="window.timeago(null, 'zh_CN').format(this.value)"></span>
            <span :title="this.value" v-else v-text="this.value"></span>
        </span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("idate",
        {
            template:"#c-<?=$vueid?>",
            data: function () {
                return {
                    editing: false
                };
            },
            props:[
                'timeago',
                'edit',
                'fulldate',
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
            methods: {
                updateValue: function () {
                    $('c-<?=$vueid?>-'+this.name).val(this.value);
                    this.$emit('input', this.value);
                }
            }
        }
    );
</script>
<?php } if($this->isInit()){ return false;}?>

<idate <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :fulldate="<?=$this->isFulldate()?'true':'false'?>" :timeago="<?=$this->isTimeAgo()?'true':'false'?>" ></idate>

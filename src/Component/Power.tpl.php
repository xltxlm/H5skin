<?php /** @var  \xltxlm\h5skin\component\Power $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>

<script type="text/x-template" id="c-<?=$vueid?>">
    <span >
        <Icon type="alert" size="20" color="red"></Icon>你当前的权限为：
        <i-Select  v-model="mypower" size="small" style="width:100px"  @on-change="powerchange">
            <i-Option  value="无权限" >无权限</i-Option>
            <i-Option  value="只读" >只读</i-Option>
            <i-Option  value="操作" >操作</i-Option>
        </i-Select>
        <span id="mypowertext" v-text="this.message" style="color: red"></span>
    </span>
</script>

<script type="application/javascript">
    Vue.component("ipower",{
        template: "#c-<?=$vueid?>",
        data: function () {
            return {
                mypower:this.power,
                message:""
            }
        },
        props: [
            "power",
            "ctroller"
        ],
        methods:{
            powerchange:function (power) {
                this.$emit('input', power);
                $.ajax(
                {
                    dataType: "json",
                    method: "POST",
                    context:this,
                    url: "<?=$this->getAjaxEditUrl()?>/?c=SsoTools/Power",
                    data:{
                        httpsport:'<?=$_SERVER['httpsport']?>',
                        ctroller:this.ctroller,
                        access:power,
                        username:'<?=$_COOKIE['username']?>'
                    },
                    success: function (result) {
                        ajaxSuccess(result);
                        vueel.requestmodelaction();
                        //页面上展示服务器返回的信息
                        this.message=result.message;
                    },
                    error:function()
                    {
                        notyf.alert("修改失败!");
                    }
                }
                );
            }
        }
    });
</script>
<?php  } if($this->isInit()){ return false;}?>
<ipower power="<?=$this->getPower()?>" ctroller="<?=$this->getCtroller()?>" ></ipower>

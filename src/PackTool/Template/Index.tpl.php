<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
use xltxlm\h5skin\SelectTPL;

$TableName=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableNameLong=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
?>
<<?='?'?>php
/** @var <?=$this->getClassName()?> $this */
use <?=$this->getClassName()?>;
<?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3){?>
use <?=$this->getClassName()?>log;
use <?=$TableNameLong?>logModel;
<?php }?>
use xltxlm\h5skin\Traits\Timepicker;
use xltxlm\h5skin\Request\UserCookieModelCopy;
<?php if($this->isMakeDelete()){?>use <?=$this->getClassName()?>DeleteDo;<?php }?>

use <?=$TableNameLong?>Type;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>;
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=$TableNameLong.'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    if($enum){
?>
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>;
<?php }}?>
<?php if($this->isExcel()){?>use <?=$this->getClassName()?>Excel;

<?php }?>
use <?=$this->getClassName()?>Ajax;
<?php if($this->isAjaxEdit()){?>
use <?=$this->getClassName()?>AjaxEdit;

<?php }?>
use xltxlm\h5skin\Traits\PageBarHtml;
use xltxlm\h5skin\SelectTPL;
use xltxlm\h5skin\Traits\DatePicker;
use xltxlm\h5skin\Traits\VueLink;
<?php if($this->isMakeAdd()){?>use <?=$this->getClassName()?>Add;<?php }?>

?>

<div id="<<?='?'?>=VueLink::vueel()?>" >
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php if($this->isMakeAdd()){?><a type="button" class="btn bg-purple margin"
                                                       href="<<?='?'?>= <?=$this->getShortName()?>Add::urlNoFollow() ?>">+添加新数据</a><?php }?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<<?='?'?>= <?=$this->getShortName()?>::url() ?>" method="post">
                <!--       隐藏的分页条         -->
                <input type="hidden" name="<?='<'?>?=UserCookieModelCopy::pageID()?>" value="<?='<'?>?=$this->getPageObject()->getPageID()?>">
                <div class="box-body">

                    <!--  分页  -->
                    <div class="form-group col-md-1 ">
                        <label   > 分页 </label>
                        <<?='?'?>=(new SelectTPL())
                        ->setOptions([
                        "分页"=>NULL
                        ]+array_combine(range(1,200,30),range(1,200,30))
                        )
                        ->setClassName('form-control')
                        ->setDefault(10)
                        ->setName('prepage')
                        ->setSelect2(false)
                        ->__invoke()?>
                    </div>

                    <?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
                        if(strpos($property->getName(),'elasticsearch')===0){continue;}
                        $isEnumFunction= $TableNameLong.'Type::'.$property->getName().'IsEnum();';
                        $enum=false;
                        eval('$enum='.$isEnumFunction);

                        ob_start();
                     ?>
                        <<?='?'?>=(new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()]?>
                        <?php  $fieldShowName=trim(ob_get_clean()); ?>


                        <!--  <?=$property->getName()?>  -->
                    <div class="form-group col-md-2 <<?='?'?>= (string)$this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>() ? 'has-error' : '' ?> ">
                        <label  class="<<?='?'?>= (string)$this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>() ? 'label label-danger' : '' ?>" for="<?=$property->getName()?>">
                            <?=$fieldShowName?>
                        </label>
                    <?php if($enum){?>
                            <<?='?'?>=(new SelectTPL())
                        ->setOptions([
                            "全部"=>NULL
                        ]+Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>::ALL())
                                ->setDefault($this->get<?=$this->getShortName()?>Request()->get<?=ucfirst($property->getName())?>())
                                ->setClassName('form-control')
                                ->setName(<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>())
                                ->__invoke()?>
                    <?php }else{?>
                                <input type="text"
                                       class="form-control <<?='?'?>php if(<?=$TableName?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>  <<?='?'?>php if(<?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Type::<?=$property->getName()?>IsTime()){?><<?='?'?>=Timepicker::getTimepickerCss()?><<?='?'?>php }?>"
                                       name="<<?='?'?>= <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>() ?>"
                                       value="<<?='?'?>=$this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()?>"
                                       id="<<?='?'?>= <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>() ?>" placeholder="<<?='?'?>=(new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()]?>">
                    <?php }?>
                    </div>
                    <?php }?>

                    <!--  排序  -->
                    <div class="form-group col-md-2 <<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'has-error' : '' ?> ">
                        <label  class="<<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'label label-danger' : '' ?>" for="webPageOrderBy">
                            排序依据
                        </label>
                        <<?='?'?> $ALLFields=(new <?=$this->TableModelClassNameReflectionClass->getShortName()?>)()?>
                        <<?='?'?>=(new SelectTPL())
                            ->setOptions([
                                    "排序"=>NULL
                                ]+array_combine(array_values($ALLFields),array_keys($ALLFields)))
                            ->setClassName('form-control')
                            ->setDefault($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy())
                            ->setName('webPageOrderBy')
                            ->__invoke()?>
                    </div>



                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" id="<?=$buttonid=md5(__LINE__)?>" onclick="var f=$('#<?=$buttonid?>').parents('form'); f.attr('action','<<?='?'?>=<?=$this->getShortName()?>::url()?>');f.submit();" class="btn btn-primary">搜索数据</button>
                    <?php if($this->isExcel()){?>
                    <<?='?'?>php if(is_file(__DIR__.'/<?=$this->getShortName()?>Excel.php')){?><a id="<?=$buttonid=md5(__LINE__)?>"  onclick="var f=$('#<?=$buttonid?>').parents('form'); f.attr('action','<<?='?'?>=<?=$this->getShortName()?>Excel::url()?>');f.submit();" class="btn btn-primary">当前页面数据另存为Excel</a><<?='?'?>php } ?>
                    <?php }?>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </div>
</div>


<template v-for=" idata in [alldata.<?='<'?>?=<?=$this->getShortName()?>Ajax::<?=$TableName?>Model()?>ed,alldata.<?='<'?>?=<?=$this->getShortName()?>Ajax::<?=$TableName?>Model()?>]">
<div class="row" v-if="idata">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <<?='?'?>=(new PageBarHtml($this))->setVue(true)->__invoke()<?='?'?>>
                <table class="table table-hover">
                    <thead>
                <tr>
                    <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){
                        if(strpos($property->getName(),'elasticsearch')===0){continue;}
                        ob_start();?>
                    <<?='?'?>=(new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()]?>
<?php  $fieldShowName=trim(ob_get_clean()); ?>
                        <!--  <?=$property->getName()?>  --><th><?=$fieldShowName?></th>
<?php }?>
                    <th>操作</th>
                </tr>
                    </thead>
                    <tbody>

<!--  vue形式展示的网页格式  -->
                        <template v-for="(item,index) in idata">
<!--          vue编辑状态下的页面              -->
                <?php if($this->isAjaxEdit()){?>
                        <tr @mouseover="openedit(item.id)" @click="openedit(item.id)" <?php if(!$this->isAjaxEditOnly()){?>@blur="openedit(0)" v-show="openeditflag == item.id"  @drop="drop(index,$event)" @dragover="dragover" draggable="true" @dragstart="dragstart(index,$event)" <?php }?>>
                            <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){
                                if(strpos($property->getName(),'elasticsearch')===0){continue;}
                                $isEnumFunction= $TableNameLong.'Type::'.$property->getName().'IsEnum();';
                                $isenum=false;
                                eval('$isenum='.$isEnumFunction);
                            ?>
<?php
    $AutoIncrement = $property->getName() == call_user_func([(new \ReflectionClass($TableNameLong))->newInstance(), 'getAutoIncrement']);
    $isAjaxEditField = in_array($property->getName(),$this->getAjaxEditField());
    if(!$isAjaxEditField){
                                    ?>
        <!--  <?=$property->getName()?>  --><td><<?='?'?>= <?=$TableName?>Model::<?=$property->name?>Vue() ?></td>
<?php }elseif ($isenum){ ?>
                    <!--  <?=$property->getName()?>  --><td>
                            <<?='?'?>=(new SelectTPL())
                                ->setOptions(Enum<?=$this->getShortName().ucfirst($property->getName())?>::ALL())
                                ->setName(<?=$TableName?>Model::<?=$property->name?>())
                                ->setVOnChange('editField')
                                ->setQuick(true)
                                ->setVmodel(<?=$TableName?>Model::<?=$property->name?>Vue(false))
                            ->__invoke()?>
<?php }else{ ?>
            <!--  <?=$property->getName()?>  --><td><input @keyup="editField()" class="<<?='?'?>php if(<?=$TableName?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>" style="width: 100%" title="" name="<<?='?'?>=<?=$TableName?>Model::<?=$property->name?>()?>" type="text" v-model="<<?='?'?>= <?=$TableName?>Model::<?=$property->name?>Vue(false) ?>"></td>
<?php }?>
<?php }?>
                            <td><?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3){?><a target="_blank" :href="'<?='<'?>?=<?=$this->getShortName()?>log::url()?>&<?='<'?>?=<?=$this->getShortName()?>logModel::pid()?>='+<?='<'?>?=<?=$this->getShortName()?>logModel::idVue(false)?>">日志</a><?php }?></td>
                        </tr>

                <?php }?>

<?php if(!$this->isAjaxEditOnly()){?>
<!--            vue查看数据下的页面               -->
                        <tr  <?php if($this->isAjaxEdit()){?>@click="openedit(item.id)"  v-show="openeditflag != item.id"<?php }?>  @drop="drop(index,$event)" @dragover="dragover" draggable="true" @dragstart="dragstart(index,$event)">
<?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){
    if(strpos($property->getName(),'elasticsearch')===0){continue;}
    ?>
                                <!--  <?=$property->getName()?>  --><td><<?='?'?>= <?=$TableName?>Model::<?=$property->name?>Vue() ?></td>
<?php }?>
                            <td>
<?php if($this->isMakeDelete()){?><a :href="'<<?='?'?>= <?=$this->getShortName()?>DeleteDo::url()?>&<<?='?'?>=<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::id()?>='+<<?='?'?>=<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::idVue(false)?>" onclick="return confirm('确认删除?')">删除</a><?php }?>

<?php if(!$this->isAjaxEdit() && $this->isMakeAdd()){?><a :href="'<<?='?'?>= <?=$this->getShortName()?>Add::url()?>&<<?='?'?>=<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::id()?>='+<<?='?'?>=<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::idVue(false)?>">编辑</a><?php }?>

                            </td>
                        </tr>
<?php }?>
                        </template>

                    </tbody>
                </table>
                <<?='?'?>=(new PageBarHtml($this))->setVue(true)->__invoke()<?='?'?>>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<div v-else="">没有数据</div>
</template>
</div>
    <?='<'?>? $Properties=(new \ReflectionClass(<?=$TableName?>Ajax::class))->getProperties();
    $define=[];
    foreach ($Properties as $Propertie)
    {
        $define[$Propertie->getName()]='';
    }
    ?>
<script>
    var alldata=JSON.parse('<?='<'?>?=json_encode($define,JSON_UNESCAPED_UNICODE)?>');
    console.log(alldata);
</script>
<?php if($this->isAjax()){?>
<<?='?'?>=(new VueLink)->setUrl(<?=$this->getShortName()?>Ajax::url())<?php if($this->isAjaxEdit()){?>->setEditAjaxUrl(<?=$this->getShortName()?>AjaxEdit::url())<?php }?>->__invoke()?>
<?php } ?>

<<?='?'?>= (new DatePicker())->setTimePicker(false)->setSingleDatePicker(false)->__invoke() ?>
<<?='?'?>= (new Timepicker())->setInterval(30)->__invoke() ?>

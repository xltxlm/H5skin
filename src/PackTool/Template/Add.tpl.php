<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */  ?>
<<?='?'?>php
/**
* Created by PhpStorm.
* User: xialintai
* Date: 2017/3/1
* Time: 19:35.
*/

namespace <?=$this->getClassNameSpace()?>;
use xltxlm\h5skin\Traits\DatePicker;
use xltxlm\h5skin\Traits\Timepicker;
use <?=$this->TableModelClassNameReflectionClass->getName()?>;
use <?=strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>''])?>Type;
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    if($enum){
?>
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>;

<?php }}?>
use xltxlm\h5skin\SelectTPL;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Horizontal Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="<<?='?'?>= <?=$this->getShortName()?>AddDo::url() ?>" method="post">
                <div class="box-body">
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    //自增id,特殊字段,一律不参与创建页面
    if($property->getName() == call_user_func([(new \ReflectionClass(strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>''])))->newInstance(),'getAutoIncrement']))
    {
        continue;
    }
    if(in_array($property->getName(),['username','status','add_time','delete_time']))
    {
        continue;
    }

    $isEnumFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    ob_start();?>
    <<?='?'?>=(new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()]?>
    <?php  $fieldShowName=trim(ob_get_clean()); ?>


    <!--  <?=$property->getName()?>  -->
                    <div class="form-group">
                        <label for="<?=$property->getName()?>" class="col-sm-2 control-label"><?=$fieldShowName?></label>
                        <div class="col-sm-6">
                            <?php if($enum){?>
                                <<?='?'?>=(new SelectTPL())
                                ->setOptions(Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>::ALL())
                                ->setClassName('form-control')
                                ->setName(<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>())
                                ->setDefault($this->get<?=$this->getShortName()?>Request()->get<?=ucfirst($property->getName())?>())
                                ->__invoke()?>
                            <?php }else{ ?>
                                <input type="text"
                                       class="form-control <<?='?'?>php if(<?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>  <<?='?'?>php if(<?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Type::<?=$property->getName()?>IsTime()){?><<?='?'?>=Timepicker::getTimepickerCss()?><<?='?'?>php }?>"
                                       id="<<?='?'?>= <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>() ?>"
                                       name="<<?='?'?>= <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>() ?>"
                                       value="<<?='?'?>= $this->get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>()->get<?=$property->getName()?>() ?>"
                                       placeholder="<?=$fieldShowName?>">
                            <?php } ?>
                        </div>
                    </div>
<?php }?>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">提交新数据</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>

<<?='?'?>= (new DatePicker($this))->setTimePicker(false)->setSingleDatePicker(false)->__invoke() ?>
<<?='?'?>= (new Timepicker($this))->setInterval(30)->__invoke() ?>

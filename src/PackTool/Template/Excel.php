<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/2/21
 * Time: 15:09.
 */

namespace <?=$this->getClassNameSpace()?>;

use <?=$this->getClassName()?>;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>;
use xltxlm\phpexcel\ExcelWrite;

ob_start();

final class <?=$this->getShortName()?>Excel extends <?=$this->getShortName()?>

{
    public function get<?=$this->getShortName()?>Excel()
    {
        ob_get_clean();
        $excelheader = [];
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
//如果标题头有包含old开头的,不要显示
    if(strpos($property->getName(),'old')===0)
    {
        continue;
    }
?>
        $excelheader[] = (new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()];
<?php } ?>

        $get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?> = $this->get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>();
        array_walk($get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>, function (&$item, $key) {
            eval('$item = $item->__toArray();');
            foreach ($item as $key => $value) {
                if (strpos($key, 'old') === 0) {
                    unset($item[$key]);
                }
            }
            eval('$item = array_values($item);');
        });

        (new ExcelWrite())
            ->setHeads($excelheader)
            ->setData($get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)
            ->setFilename('<?=$this->getShortName()?>Excel.xlsx')
            ->__invoke();
        flush();
        die;
    }
}

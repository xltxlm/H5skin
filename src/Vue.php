<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/1/3
 * Time: 16:20.
 */

namespace xltxlm\h5skin;

/**
 * 网页模型用上 vue参数
 * Class Vue
 * @package xltxlm\vue
 */
trait Vue
{
    protected $vmodel = '';
    protected $vOnChange = '';

    /**
     * @return string
     */
    public function getVmodel(): string
    {
        return $this->vmodel ? "v-model='{$this->vmodel}'" : '';
    }

    /**
     * @param string $vmodel
     *
     * @return $this
     */
    public function setVmodel(string $vmodel)
    {
        $this->vmodel = $vmodel;

        return $this;
    }

    /**
     * @return string
     */
    public function getVOnChange(): string
    {
        return $this->vOnChange ? "v-on:change='{$this->vOnChange}'" : '';
    }

    /**
     * @param string $vOnChange
     *
     * @return $this
     */
    public function setVOnChange(string $vOnChange)
    {
        $this->vOnChange = $vOnChange;

        return $this;
    }
}

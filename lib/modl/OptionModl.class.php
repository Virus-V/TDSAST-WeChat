<?php
namespace Vpf\App\Modl;
use Vpf;

class OptionModl extends \Vpf\Modl
{
	public function get_option($optionKey = null)
	{
		$option = array();
		$optionAll = array();
		$o = $this->select();
		if(!$o) Vpf\halt('get options Failed');
		foreach($o as $v)
		{
			if(0 != $v['o_is_array'])
			{
				$optionAll[$v['o_key']] = json_decode($v['o_value'], true);
			}
			else
			{
				$optionAll[$v['o_key']] = $v['o_value'];
			}

		}
		if(is_string($optionKey))
		{
			$o = $optionAll;
			$key = explode('/', $optionKey);
			foreach($key as $key)
			{
				$o = $o[$key];
			}
			$option = $o;
		}
		elseif(is_array($optionKey))
		{
			foreach($optionKey as $key)
			{
				$option[$key] = $this->get_option($key);
			}
		}
		else
		{
			$option = $optionAll;
		}
		return $option;
	}
	
	/** 保存多个参数 */
	public function save_options($option)
	{
		if(is_array($option))
		{
			foreach($option as $k => $v)
			{
				$this->save_option($k,$v);
			}
			return true;
		}
		return false;
	}
	
	/** 保存单个参数 */
	public function save_option($k,$v)
	{
		$where['o_key'] = array('EQ', $k);
		$o = $this->where($where)->find();
        if(!$o)return false;
		if(0 == $o['o_is_array'])
		{
			return $this->where($where)->set_field('o_value',$v);
		}
		elseif(1 == $o['o_is_array'])
		{
			return $this->where($where)->set_field('o_value',json_encode($v));
		}
	}
}
?>
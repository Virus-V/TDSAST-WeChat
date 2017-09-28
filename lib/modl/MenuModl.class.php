<?php
namespace Vpf\App\Modl;
use Vpf;

final class MenuModl extends \Vpf\Modl{
    
    /* 获得菜单 */
    public function getMenu(){
        return $this->order('`m_index` desc')->select();
    }
    
    /* 获得菜单列表 */
    public function addMenu(){
        $this->create();
        return $this->insert();
    }
    
    /* 更新图文消息 */
    public function updateNews($data){
        if(empty($data)) return false;
        $this->create($data);
        return $this->update();
    }
    
    /* 删除按钮，支持多个 */
    public function delMenu($mid){
        return $this->where('`m_id` IN('.$mid.')')->delete();
    }
}
?>
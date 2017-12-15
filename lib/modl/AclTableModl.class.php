<?php
namespace Vpf\App\Modl;
use Vpf;
/**
 * ACL 科协大门权限控制
 */
final class AclTableModl extends \Vpf\Modl{
    
    /* 由开门者的openid获得开门者的信息 */
    public function getInfo($openid){
        $where['openid'] = $openid;
        return $this->where($where)->find();
    }
    
    /* 删除按钮，支持多个 */
    // public function delMenu($mid){
    //     return $this->where('`m_id` IN('.$mid.')')->delete();
    // }
}
?>
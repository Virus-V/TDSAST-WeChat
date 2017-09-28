<?php
namespace Vpf\App\Modl;
use Vpf;

final class RaffleModl extends \Vpf\App\Modl{
    
    public function getByOpenID($o_id){
        $where['openid'] = $o_id;
        return $this->where($where)->find();
    }
    
    public function addRaffle($o_id, $nickname, $is_draw, $prize){
        $arr = array(
            'openid' => $o_id,
            'nickname' => $nickname,
            'is_draw' => $is_draw,
            'prize' => $prize,
            'date' => time(),
        );
        $this->create($arr);
        return $this->insert();
    }
}
?>
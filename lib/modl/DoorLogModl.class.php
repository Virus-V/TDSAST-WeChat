<?php
namespace Vpf\App\Modl;
use Vpf;
/**
 * 开门日志记录
 */
final class DoorLogModl extends \Vpf\Modl{
    
    /* 插入开门日志 */
    public function addLog($stu_id, $result = 1){
        $data = array(
            'stu_id' => $stu_id,
            'time' => time(),
            'result' => $result ? 1 : 0
        );
        $this->create($data);
        return $this->insert();
    }
}
?>
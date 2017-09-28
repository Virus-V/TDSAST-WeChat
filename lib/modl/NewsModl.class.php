<?php
namespace Vpf\App\Modl;
use Vpf;

final class NewsModl extends \Vpf\Modl{
    
    public function getNews($catalogue, $limit = 5){
        if(empty($catalogue)) return false;
        return $this->where('`n_catalogue` = \''.$catalogue.'\' and `n_enable` = 1')->order('`n_id` DESC')->limit($limit)->select();
    }
    
    /* 增加图文消息 */
    public function addNews($catalogue, $data){
        if(empty($data) || empty($catalogue)) return false;
        $data['n_catalogue'] = $catalogue;
        $data['n_enable'] = isset($data['n_enable']) ? $data['n_enable'] : 1;
        $this->create($data);
        return $this->insert();
    }
    
    /* 更新图文消息 */
    public function updateNews($data){
        if(empty($data)) return false;
        $this->create($data);
        return $this->update();
    }
    
    /* 删除图文消息，支持多个 */
    public function deleteNews($nid){
        return $this->where('`n_id` IN('.$nid.')')->delete();
    }
}
?>
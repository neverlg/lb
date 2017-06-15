<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  师傅
*/

class Master extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	//发现
	public function discover(){
//	    echo '<pre>';
//	    var_dump(getAreas('provinceIds'));
        $data = [];
        $area_id = $this->input->get('areaId');
        $data['area_id'] = $area_id;
        $service_type = $this->input->get('service_type');
        $data['service_type'] = $service_type;
        if ($area_id){
            $page = $this->input->get('p') ? : 1;
            $num_per_page = config_item('num_per_page');
            $this->load->model('master_model');
            $qiniu = config_item('qiniu');
            $count = $this->master_model->get_suitable_user_num($area_id,$service_type);
            $data['count'] = $count;

            $users = $this->master_model->get_suitable_user($area_id,$service_type,$page,$num_per_page['order_index']);
            foreach ($users as $key => &$user) {
                $user['head_img'] = $user['head_img']? (strpos($user['head_img'],'http') === 0 ? $user['head_img']:$qiniu['source_url'].$user['head_img']) : asset('images/default_head.png');
                $user['service_type_text'] = implode(',',getServiceTypeText(explode(',',$user['service_type'])));
                $user['service_area_text'] = implode(',',getServiceAreasText(explode(',',$user['service_area_ids'])));

                $user['avg_score'] = sprintf('%.2f',$user['score_count'] ? $user['score_sum']/$user['score_count'] : 0);
                $user['praise_rate'] = sprintf('%.2f',$user['evaluate_count'] ? $user['evaluate_praise_count']/$user['evaluate_count']*100 : 0);
                $user['stars'] = getStars($user['points']);
            }
            $data['list'] = $users;

            $this->load->library('pag');
            $this->pag->config($count,$num_per_page['order_index'],3);
            $data['__pagination_url'] = $this->pag;

            $this->load->model('province_model');
            $parentsCouple = $this->province_model->getParentsCouple($area_id);
            list($provinceId,$cityId,$districtId) = array_keys($parentsCouple);
            $data['provinceId'] = $provinceId;
            $data['cityId'] = $cityId;
            $data['districtId'] = $districtId;
        }
		$this->load->view('master/discover',$data);
	}

}

function getServiceTypeText(array $service_types)
{
    $service_type_config = config_item('service_type');
    $service_type_text = [];
    foreach ($service_types as $service_type){
        $service_type_text[] = @$service_type_config[$service_type];
    }
    return array_filter($service_type_text);
}

function getServiceAreasText(array $service_area_ids)
{
    $areas = getAreas();
    $service_areas = [];
    foreach ($service_area_ids as $service_area_id){
        $service_areas[] = @$areas[$service_area_id]['n'];
    }
    return array_filter($service_areas);
}

function getStars($points)
{
    switch (true){
        case $points == 0:
            return 0;
        case $points <= 5:
            return str_repeat('<img src="'.asset('images/bj2.png').'">',1);
        case $points <= 20:
            return str_repeat('<img src="'.asset('images/bj2.png').'">',2);
        case $points <= 45:
            return str_repeat('<img src="'.asset('images/bj2.png').'">',3);
        case $points <= 75:
            return str_repeat('<img src="'.asset('images/bj2.png').'">',4);
        case $points <= 125:
            return str_repeat('<img src="'.asset('images/bj2.png').'">',5);
        case $points <= 250:
            return str_repeat('<img src="'.asset('images/bj4.png').'">',1);
        case $points <= 500:
            return str_repeat('<img src="'.asset('images/bj4.png').'">',2);
        case $points <= 1000:
            return str_repeat('<img src="'.asset('images/bj4.png').'">',3);
        case $points <= 2500:
            return str_repeat('<img src="'.asset('images/bj4.png').'">',4);
        case $points <= 5000:
            return str_repeat('<img src="'.asset('images/bj4.png').'">',5);
        case $points <= 10000:
            return str_repeat('<img src="'.asset('images/bj5.png').'">',1);
        case $points <= 25000:
            return str_repeat('<img src="'.asset('images/bj5.png').'">',2);
        case $points <= 50000:
            return str_repeat('<img src="'.asset('images/bj5.png').'">',3);
        case $points <= 100000:
            return str_repeat('<img src="'.asset('images/bj5.png').'">',4);
        case $points > 100000:
            return str_repeat('<img src="'.asset('images/bj5.png').'">',5);
        default:
            return 0;
    }
    return 0;
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 扩展核心 - 控制器
 */

class MY_Controller extends CI_Controller {


    public function __construct(){
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->model('message_model');
        //消息数目
        $this->_message_count = 0;
        $this->_current_controller = strtolower($this->uri->rsegment(1));
        $this->_current_method = strtolower($this->uri->rsegment(2));
        $this->_authorization();

        $this->output->enable_profiler(TRUE);
    }

    // auth check
    private function _authorization() {
        //allow vivit without login
        $_allow_visit = array(
            'main' => array(
                'index',               #首页
                'about_us',            #关于我们 
                'master_settle',       #师傅入驻
                'guarantee',           #服务保障
                'service',             #服务方式
                'shortcut',            #快捷方式 
                ),
            'auth' => array(
                'user_captcha',        #ajax create captcha
                'login_submit',        #提交登陆ajax
                'send_sms',            #短信发送
                'register',            #注册页面
                'register_submit',     #提交注册ajax
                'forget_password',     #忘记密码
                'forget_submit',       #忘记密码提交
                'priced_apply',        #定价批量下单申请页
                'priced_submit',       #定价批量下单申请提交
                ),
            'article' => array(
                'index',               #帮助中心
                'detail',              #具体文章内容
                ),
            'message' => array(
                'feedback',            #用户反馈
                'feedback_submit',     #反馈提交
                ),
            'master' => array(
                'discover',            #发现师傅
            ),
            'activity' => array(
                'index',     #优惠活动
            ),
            );
        // need no login
        if(isset($_allow_visit[$this->_current_controller]) && in_array($this->_current_method, $_allow_visit[$this->_current_controller])){
            return;
        }
        //check login
        if($this->auth_model->is_login()){
            $me_id = $this->session->userdata('me_id');
            $this->_message_count = $this->message_model->get_unread_total($me_id);
            return;
        }
        //login
        redirect('main/index/login');
    }
    
}
<?php

class Admin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

    }


    // this function will redirect to book service page
    function index()
    {
        if($this->session->userdata('logged_in') == '1'){
            $this->subscribe(); 
        }else{
            $this->login();
        }
        
    }

    // this function to load service book page
    function subscribe()
    {
        $this->load->view('site_subscribe');
    }
	

    function login()
    {
        $this->load->view('login_page');
    }
    
    function chek_login()
    {
        $login = $this->input->post('login');
        $password = $this->input->post('password');
        
        if($login == ULOGIN and $password == UPASSWORD){
            $this->session->set_userdata('logged_in', '1');
            redirect(CMS_URI.'/admin');
        }else{
            echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">';
            echo '<div class="row"><div class="col-md-12"><p class="text-center"><h3 class="text-center" style="color:#dd4814;font-weight: 700;">Wrong!<h3></p>';
            echo '<p class="text-center"><button onclick="location.href=\''.CMS_URI.'/admin\';" type="button" class="btn btn-danger">TRY AGAIN</button></p>';
            echo '</div></div>';
        }
        
    }
    
    function logout()
    {
        $this->session->sess_destroy();  // обнуляем сессию
        redirect(CMS_URI.'/admin');
    }
    
    /**
     * Create New Notification
     *
     * Creates adjacency list based on item (id or slug) and shows leafs related only to current item
     *
     * @param int $user_id Current user id
     * @param string $title Current title
     *
     * @return string $response
     */
    function send_message(){
        $message = $this->input->post("message");
        $user_id = $this->input->post("user_id");
		$url = $this->input->post("url");
		$headings = $this->input->post("headings");
		$img = $this->input->post("img");
		
		
        $content = array(
            "en" => "$message"
        );
		$headings = array(
            "en" => "$headings"
        );

        $fields = array(
            'app_id' => APPID,
            'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
			'url' => $url,
			'contents' => $content,
			'chrome_web_icon' => $img,
			'headings' => $headings
        );

        $fields = json_encode($fields);
        //print("\nJSON sent:\n");
        //print($fields);
        
        
        
        echo '<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">';
        echo '<div class="row"><div class="col-md-12"><p class="text-center"><h3 class="text-center" style="color:#00e600;font-weight: 700;">Message sent</h3></p>';
        echo '<p class="text-center"><button onclick="location.href=\''.CMS_URI.'/admin\';" type="button" class="btn btn-success">SEND ANOTHER MESSAGE</button></p>';
        echo '</div></div>';




        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.APKEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
       return $response;
    }

}
/* End of file news.php */
/* Location: ./application/controllers/Services.php */
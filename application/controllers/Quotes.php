<?php

class Quotes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

    }


    // this function will redirect to book service page
    function index()
    {
        $this->subscribe();
    }

    // this function to load service book page
    function subscribe()
    {
        $this->load->view('site_subscribe');
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
        print("\nJSON sent:\n");
        print($fields);

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
/* End of file quotes.php */
/* Location: ./application/controllers/Services.php */
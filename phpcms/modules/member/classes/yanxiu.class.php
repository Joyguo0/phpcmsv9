<?php

class yanxiu {
	public $secret_key='ssdfdfdfo2222dfdf999990().>>dfdkk';
	public $tp='100100';
	
	public function passport_check($data) {
		$result=array('flag'=>false,'info'=>'');
		$tst = time ();
		$data = array ( 'tp' => $this->tp,
						'pp' => $data['username'], 
						'pwd' => md5 ( $data['pwd'] ), 
						'tst' => $tst, 
						'key' => md5 ( ($data['username'] . $tst . $this->secret_key) ) );
		$yanxiu_return_msg = $this->postdatacurl ( $data, 'http://pp.yanxiu.com/reg/loginValidate.tc' );
		print_R($yanxiu_return_msg);
		if(trim($yanxiu_return_msg->code) == 0) {
			$data_userinfo=array( 'tp' => $this->tp,
								'pp' => $data['username'], 
								'tst' => $tst, 
								'key' => md5 ( ($data['username'] .$this->tp. $tst . $this->secret_key) ) );
			$userinfo = $this->postdatacurl ( $data, 'http://pp.yanxiu.com/reg/getUserInfo.tc' );
			$result=array('flag'=>true,'info'=>$userinfo);
		}
		return $result;
	}
	
	public function postdatacurl($data, $url) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		$result = curl_exec ( $ch );
		return json_decode ( $result );
	}

}
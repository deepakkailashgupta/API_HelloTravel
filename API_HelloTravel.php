<?php

class API_HelloTravel{

	const WEBSITE_ID = 6666;
	const AFFILIATE_ID = 6666;
	
	
	const API_URL = 'http://agents.hellotravel.com/api/partner-lead.php';
	
	static function createLead($arr_lead_data = array()){
			

		$CI = &get_instance();
		
		$arr_get_data = array();
		
		$arr_get_data['aid'] = self::AFFILIATE_ID;
		$arr_get_data['website_id'] = self::WEBSITE_ID;
		$arr_get_data['duration'] = 1;
		$arr_get_data['adult'] = 2;
		$arr_get_data['kid'] = 1;
		$arr_get_data['budget'] = 1;
		$arr_get_data['tour_style'] = 1;
		$arr_get_data['country_from'] = 'IN';
		$arr_get_data['country_to'] = 'IN';
		$arr_get_data['self_url'] = base_url();
		$arr_get_data['referer'] = $CI->config->item('domain_name');
		
		if(!empty($arr_lead_data['arrival'])) $arr_get_data['arrival'] = $arr_lead_data['arrival'];

		if(!empty($arr_lead_data['adult'])){
			
			if($arr_lead_data['adult'] == '5+'){
			
				$arr_get_data['adult'] = 7;
				
			}else{
				$arr_get_data['adult'] =  intval($arr_lead_data['adult']) > 6 ? 7 : intval($arr_lead_data['adult']) ;
			}
		}
		if(!empty($arr_lead_data['kid'])) $arr_get_data['kid'] = intval($arr_lead_data['kid']) > 5 ? 6 : intval($arr_lead_data['kid']) +1 ;
	
	
		if(!empty($arr_lead_data['name'])) $arr_get_data['name'] = $arr_lead_data['name'];		
		if(!empty($arr_lead_data['email'])) $arr_get_data['email'] = $arr_lead_data['email'];	
			
		if(!empty($arr_lead_data['country_from'])) $arr_get_data['country_from'] = $arr_lead_data['country_from'];		
		if(!empty($arr_lead_data['city'])) $arr_get_data['city'] = $arr_lead_data['city'];		
		if(!empty($arr_lead_data['country_to'])) $arr_get_data['country_to'] = $arr_lead_data['country_to'];	
		if(!empty($arr_lead_data['to_city'])) $arr_get_data['to_city'] = $arr_lead_data['to_city'];		
		
		if(!empty($arr_lead_data['phone'])) $arr_get_data['phone'] = $arr_lead_data['phone'];	
			
		if(!empty($arr_lead_data['ip'])) $arr_get_data['ip'] = $arr_lead_data['ip'];		
		
		if(!empty($arr_lead_data['des'])) $arr_get_data['des'] = $arr_lead_data['des'];		
		if(!empty($arr_lead_data['referer'])) $arr_get_data['referer'] = $arr_lead_data['referer'];		
		if(!empty($arr_lead_data['self_url'])) $arr_get_data['self_url'] = $arr_lead_data['self_url'];				
		
		if(!empty($arr_lead_data['duration'])){
			if($arr_lead_data['duration'] >= 1 && $arr_lead_data['duration'] <=3){
				$arr_get_data['budget'] = 1;
			}elseif($arr_lead_data['duration'] >= 4 && $arr_lead_data['duration'] <=7){
				$arr_get_data['budget'] = 2;
			}elseif($arr_lead_data['duration'] >= 8 && $arr_lead_data['duration'] <=14){
				$arr_get_data['budget'] = 3;
			}elseif($arr_lead_data['duration'] >= 15 && $arr_lead_data['duration'] <= 21){
				$arr_get_data['budget'] = 4;
			}elseif($arr_lead_data['duration'] > 21){
				$arr_get_data['budget'] = 5;
			}
		}
		
				
		if(!empty($arr_lead_data['budget_range'])){
			switch($arr_lead_data['budget_range']){
				
				case 'economy':  $arr_get_data['budget'] = 1;break;
				case 'dtandard':$arr_get_data['budget'] = 2;break;
				case 'luxury': $arr_get_data['budget'] = 3;break;											
			}
		}
		
		if(!empty($arr_lead_data['package_type'])){
			switch($arr_lead_data['package_type']){
				
				case 'honeymoon': $arr_get_data['tour_style'] = 2;break;
				case 'couple':$arr_get_data['tour_style'] = 3;break;
				case 'family':$arr_get_data['tour_style'] = 1;break;
				case 'students':$arr_get_data['tour_style'] = 3;break;
				case 'corporate':$arr_get_data['tour_style'] = 4;break;				
				case 'group': $arr_get_data['tour_style'] = 3;break;
				case 'other': $arr_get_data['tour_style'] = 3;break;											
			}
		}		
		if(strlen($arr_lead_data['country'])  > 2){
 
			if(empty($arr_get_data['country_from'])) $arr_get_data['country_from'] = 'IN';
		}
 
		
		try{
		
			$CI->load->library('curl');
			
			$CI->curl->option(CURLOPT_RETURNTRANSFER,true);
			
			$CI->curl->option(CURLOPT_HEADER,0);
			
		  	$res = $CI->curl->simple_get(self::API_URL,$arr_get_data);
			
			if($res) echo 'send successfully<br/>';
			
			$CI->curl->debug(); 			
			
		}catch(Exception $e){
			
			echo 'Error Occured :: ';
			
			echo $e->getMessage();
			
		}
		
			
	}
}

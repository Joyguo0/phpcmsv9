<?php
//defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('category','admin',0);
include PC_PATH.'modules/admin/category.php';
class region extends category {
	public function __construct() {
		//self::check_admin();
		//self::check_priv();
		//pc_base::load_app_func('global','admin');
		//if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		/* if(pc_base::load_config('system','admin_url') && $_SERVER["HTTP_HOST"]!= pc_base::load_config('system','admin_url')) {
			Header("http/1.1 403 Forbidden");
			exit('No permission resources.');
		} */
		$this->siteid = $this->get_siteid();
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
	public function treeRegion($data){
		
		foreach ($data as $o){
			echo "<tr>
					<td align='left'><a href='#".$o->gbcode.'_'.$o->code."'>".$o->gbvalue."</a></td>
					<td align='center'></td>
					<td align='center' ><a href='#".$o->gbcode.'_'.$o->code."'>修改</a></td>
				</tr>";
			if($o->subarea){
				$this->treeRegion($o->subarea);
			}
		}
	}
	
	public function init () {
		$id=381;
		$data = $this->postdatacurl(array(), 'http://p.yanxiu.com/panel/channel/statistic/sq/areacode/'.$id.'/'.$id.'.inc' );
		echo "<table><tr>
					<td align='left'>栏目名称</td>
					<td align='center'>访问</td>
					<td align='center'>操作</td>
				</tr>";
		$this->treeRegion($data);
		echo '</table>';
		//include $this->admin_tpl('category_manage');
	}
	public function page() {
		include $this->admin_tpl('region');
	}
	public function item() {
		include $this->admin_tpl('item');
	}

	
}
?>
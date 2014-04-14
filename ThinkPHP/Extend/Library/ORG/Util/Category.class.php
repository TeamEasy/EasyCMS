<?php
/**
* 
*/
class Category
{
	Static Public function unlimitedForLevel($cate,$html='&nbsp;&nbsp;&nbsp;&nbsp;',$pid=0,$level=0){
		$arr = array();
		foreach ($cate as $v) {
			if ($v['pid'] == $pid) {
				$v['level'] = $level + 1;
				$html2=$level==0?'':'|--';
				$v['html'] = str_repeat($html,$level).$html2;
				$arr[]=$v;
				$arr = array_merge($arr,self::unlimitedForLevel($cate,$html,$v['id'],$level + 1));
			}
		}
		return $arr;
	}
	
}
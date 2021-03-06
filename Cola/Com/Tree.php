<?php

/**
 * 通用的树型类，可以生成任何树型结构
 */

class Cola_Com_Tree
{

    /**
     * 生成树型结构所需要的2维数组
     * @var array
     */
    public $arr = array();

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     * @var array
     */
    public $icon = array('│', '├', '└');
    public $nbsp = "&nbsp;";

    /**
     * @access private
     */
    public $ret = '';

    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
     *      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
     *      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
     *      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
     *      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
     *      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
     *      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
     *      )
     */
    public function __construct($arr = array())
    {
        if (!empty($arr)) $this->arr = $arr;
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    public function getParent($myid,$pid_name='parentid')
    {
        $newarr = array();
        if (!isset($this->arr[$myid])) return false;
        $pid = $this->arr[$myid][$pid_name];
        $pid = $this->arr[$pid][$pid_name];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a[$pid_name] == $pid) $newarr[$id] = $a;
            }
        }
        return $newarr;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    public function getChild($myid,$pid_name='parentid')
    {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a[$pid_name] == $myid) $newarr[$id] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到当前位置数组
     * @param int
     * @return array
     */
    public function getPos($myid, &$newarr)
    {
        $a = array();
        if (!isset($this->arr[$myid])) return false;
        $newarr[] = $this->arr[$myid];
        $pid = $this->arr[$myid]['parentid'];
        if (isset($this->arr[$pid])) {
            $this->getPos($pid, $newarr);
        }
        if (is_array($newarr)) {
            krsort($newarr);
            foreach ($newarr as $v) {
                $a[$v['id']] = $v;
            }
        }
        return $a;
    }

    /**
     * 得到树型结构
     * @param int ID，表示获得这个ID下的所有子级
     * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
     * @param int 被选中的ID，比如在做树型下拉框的时候需要用到
     * @return string
     */
    public function getTree($myid, $str, $sid = 0, $adds = '', $str_group = '')
    {
        $number = 1;
        $child = $this->getChild($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $value) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                $selected = $id == $sid ? 'selected' : '';
                @extract($value);
                $parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $nbsp = $this->nbsp;
                $this->getTree($id, $str, $sid, $adds . $k . $nbsp, $str_group);
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 同上一方法类似,但允许多选
     */
    public function getTreeMulti($myid, $str, $sid = 0, $adds = '')
    {
        $number = 1;
        $child = $this->getChild($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $this->getTreeMulti($id, $str, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * @param integer $myid 要查询的ID
     * @param string $str   第一种HTML代码方式
     * @param string $str2  第二种HTML代码方式
     * @param integer $sid  默认选中
     * @param integer $adds 前缀
     */
    public function getTreeCategory($myid, $str, $str2, $sid = 0, $adds = '')
    {
        $number = 1;
        $child = $this->getChild($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                if (empty($html_disabled)) {
                    eval("\$nstr = \"$str\";");
                } else {
                    eval("\$nstr = \"$str2\";");
                }
                $this->ret .= $nstr;
                $this->getTreeCategory($id, $str, $str2, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持）
     * @param $myid 表示获得这个ID下的所有子级
     * @param $effected_id 需要生成treeview目录数的id
     * @param $str 末级样式
     * @param $str2 目录级别样式
     * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
     * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
     * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数
     * @param $recursion 递归使用 外部调用时为FALSE
     */
    function getTreeview($myid, $pid_name='',$effected_id = 'example', $str = "<span class='file'>\$name</span>", $str2 = "<span class='folder'>\$name</span>", $showlevel = 0, $style = 'filetree ', $currentlevel = 1, $recursion = FALSE)
    {
        
        $child = $this->getChild($myid,$pid_name);
        if (!defined('EFFECTED_INIT')) {
            $effected = ' id="' . $effected_id . '"';
            define('EFFECTED_INIT', 1);
        } else {
            $effected = '';
        }
        $placeholder = '<ul><li><span class="placeholder"></span></li></ul>';
        if (!$recursion) $this->str .='<ul' . $effected . '  class="' . $style . '">';
        foreach ($child as $key => $a) {
            
            
            @extract($a);
            
            if ($showlevel > 0 && $showlevel == $currentlevel && $this->getChild($id,$pid_name)) $folder = 'hasChildren'; //如设置显示层级模式@2011.07.01
            $floder_status = isset($folder) ? ' class="' . $folder . '"' : '';
            $this->str .= $recursion ? '<ul><li' . $floder_status . ' id=\'' . $id . '\'>' : '<li' . $floder_status . ' id=\'' . $id . '\'>';
            $recursion = FALSE;
            
            if ($this->getChild($id,$pid_name)) {
                eval("\$nstr = \"$str2\";");
                $this->str .= $nstr;
                if ($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    //var_dump($id, $effected_id, $str, $str2, $showlevel, $style, $currentlevel + 1, TRUE);die;
                    $this->getTreeview($id, $pid_name,$effected_id, $str, $str2, $showlevel, $style, $currentlevel + 1, TRUE);
                } elseif ($showlevel > 0 && $showlevel == $currentlevel) {
                    $this->str .= $placeholder;
                }
            } else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .=$recursion ? '</li></ul>' : '</li>';
           
        }
        if (!$recursion) $this->str .='</ul>';
        return $this->str;
    }

    /**
     * 获取子栏目json
     * Enter description here ...
     * @param unknown_type $myid
     */
    public function creatSubJson($myid, $str = '')
    {
        $sub_cats = $this->getChild($myid);
        $n = 0;
        if (is_array($sub_cats)) foreach ($sub_cats as $c) {
                $data[$n]['id'] = iconv(CHARSET, 'utf-8', $c['catid']);
                if ($this->getChild($c['catid'])) {
                    $data[$n]['liclass'] = 'hasChildren';
                    $data[$n]['children'] = array(array('text' => '&nbsp;', 'classes' => 'placeholder'));
                    $data[$n]['classes'] = 'folder';
                    $data[$n]['text'] = iconv(CHARSET, 'utf-8', $c['catname']);
                } else {
                    if ($str) {
                        @extract(array_iconv($c, CHARSET, 'utf-8'));
                        eval("\$data[$n]['text'] = \"$str\";");
                    } else {
                        $data[$n]['text'] = iconv(CHARSET, 'utf-8', $c['catname']);
                    }
                }
                $n++;
            }
        return json_encode($data);
    }

    private function have($list, $item)
    {
        return(strpos(',,' . $list . ',', ',' . $item . ','));
    }
    
public static function draw_tree($arr, $tree, $level, &$temp_arr, $out, $index,
            $id, $pid, $name, $cookfiled = null, $cookfiledvalue = null)
    {
        $level++;
        $prefix0 = str_pad('└──', $level, '─', STR_PAD_RIGHT);
        $prefix1 = str_pad('├──', $level, '─', STR_PAD_RIGHT);
        $n = str_pad('', $level * 24, '&nbsp;', STR_PAD_RIGHT);
        $all = count($arr) - 1;
        //$n = str_replace("-", "&nbsp;", $n);
        foreach ($arr as $k2 => $v2) {
            if ($k2 != $all)
                $prefix = $prefix1;
            else
                $prefix = $prefix0;
            $idvalue = $v2[$id];
            $namevalue = $v2[$name];
            if ($out == 'option') {
                if (isset($cookfiled)) {
                    if ($v2[$cookfiled] == $cookfiledvalue) {
                        $v2[$name] = '----------';
                        $v2[$id] = '';
                    }
                }
                if ($index == $idvalue) {
                    $v2['option'] = "<option value=\"{$v2[$id]}\" selected=\"selected\">{$n}{$prefix}{$v2[$name]}</option>";
                } else {
                    $v2['option'] = "<option value=\"{$v2[$id]}\">{$n}{$prefix}{$v2[$name]}</option>";
                }
            } elseif ($out == 'cat') {
                $v2['ext'] = $n . $prefix;
                $v2['level'] = $level;
            } else {
                if (isset($cookfiled)) {
                    if ($v2[$cookfiled] == $cookfiledvalue) {
                        $v2[$name] = '----------';
                        $v2[$id] = '';
                    }
                }
                $v2['ext'] = $n . $prefix;
                $v2['level'] = $level;
            }
            if (isset($tree[$idvalue])) {
                $v2['have_child'] = 1;
                $temp_arr[] = $v2;
                self::draw_tree($tree[$idvalue], $tree, $level, $temp_arr, $out, $index, $id, $pid,
                        $name);
            } else {
                $v2['have_child'] = 0;
                $temp_arr[] = $v2;
            }
        }
    }
    
    public static function get_trees($array, &$temp_arr, $out = 'option', $index = null,
            $id = 'id', $pid = 'pid', $name = 'name', $cookfiled = null, $cookfiledvalue = null)
    {
        $tree = array();
        if ($array) {
            foreach ($array as $v) {
                $pt = $v[$pid];
                $list = isset($tree[$pt]) ? $tree[$pt] : array();
                array_push($list, $v);
                $tree[$pt] = $list;
            }
        }
        if ($tree) {
            @$tree[0] or $tree[0] = $tree[$array[0][$pid]];
            foreach ($tree[0] as $k => $v) {
                $idvalue = $v[$id];
                $namevalue = $v[$name];
                if ($out == 'option') {
                    if (isset($cookfiled)) {
                        if ($v[$cookfiled] == $cookfiledvalue) {
                            $v[$name] = '----------';
                            $v[$id] = '';
                        }
                    }
                    if ($index == $v[$id]) {
                        $v['option'] = "<option value=\"{$v[$id]}\" selected=\"selected\">{$v[$name]}</option>";
                    } else {
                        $v['option'] = "<option value=\"{$v[$id]}\">{$v[$name]}</option>";
                    }
                } elseif ($out == 'cat') {
                    $v['ext'] = '';
                    $v['level'] = 0;
                } else {
                    if (isset($cookfiled)) {
                        if ($v[$cookfiled] == $cookfiledvalue) {
                            $v[$name] = '----------';
                            $v[$id] = '';
                        }
                    }
                    $v2['ext'] = '';
                    $v['level'] = 0;
                }
                if (isset($tree[$idvalue])) {
                    $v['have_child'] = 1;
                    $temp_arr[] = $v;
                    self::draw_tree($tree[$idvalue], $tree, 0, $temp_arr, $out, $index, $id, $pid, $name,
                            $cookfiled, $cookfiledvalue);
                } else {
                    $v['have_child'] = 0;
                    $temp_arr[] = $v;
                }
            }
        }
    }

}
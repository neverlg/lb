<?php

/*
 * $pag = new pagination(5,20);
 * echo $pag;
 * or
 * echo $pag->subPageCss1();
 * or
 * echo $pag->subPageCss2();
 * 
 * mysql_query("select * from user limit {$pag->offset},{$pag->limit}");
 */

class Pag {

    private static $count = 0;//分页单元框数量
    
    private $each_disNums; //每页显示的条目数 
    private $nums; //总条目数 
    private $current_page; //当前被选中的页 
    private $sub_pages; //每次显示的页数 
    private $pageNums; //总页数 
    private $page_array = array(); //用来构造分页的数组 
    private $subPage_link; //每个分页的链接 
    private $subPage_type; //显示分页的类型 
    private $query = array();//get请求数组
    private $limit_select = array('10'=>10,'50'=>50,'200'=>200,'1000'=>1000,'10000'=>10000);

    public $offset;//位移量
    public $limit;//每页数量
    /*
      __construct是SubPages的构造函数，用来在创建类的时候自动运行.
      @$each_disNums   每页显示的条目数
      @nums     总条目数
      @current_page     当前被选中的页
      @sub_pages       每次显示的页数
      @subPage_link    每个分页的链接
      @subPage_type    显示分页的类型

      当@subPage_type=1的时候为普通分页模式
      example：   共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页]
      当@subPage_type=2的时候为经典分页样式
      example：   当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页]
     */

    function config($nums, $each_disNums = 10, $subPage_type = 3, $current_page = null, $sub_pages = null, $subPage_link = null) {
        if (!$current_page)
            $current_page = (isset($_GET['p']) && (int)$_GET['p'])?$_GET['p']:1;
        if (!$sub_pages)
            $sub_pages = 10;
        if (!$subPage_link){
            $subPage_link = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
            $this->query = $_GET;
            //$subPage_link .= '?'.http_build_query($_GET+array('p'=>''));
        }

        $this->each_disNums = intval($each_disNums);
        $limit = isset($_COOKIE['paginationLength'])?$_COOKIE['paginationLength']:$each_disNums;
        if ($_POST && isset($_POST['paginationLength'])){
            setcookie('paginationLength',$_POST['paginationLength']);
            $limit = $_POST['paginationLength'];
        }

        $this->nums = intval($nums);
        if (!$current_page) {
            $this->current_page = 1;
        } else {
            $this->current_page = intval($current_page);
        }
        $this->sub_pages = intval($sub_pages);
        //$this->pageNums = ceil($nums / $each_disNums);
        $this->pageNums = ceil($nums / $limit);
        $this->subPage_link = $subPage_link;

        $this->limit = $limit;//$this->each_disNums;
        $this->offset = ($this->current_page-1) * $this->limit;

        $this->subPage_type = $subPage_type;
        //echo $this->pageNums."--".$this->sub_pages;
    }
    
    public function __toString() {
        self::$count++;
        return '<form action="" method="post" id="paginationForm'.self::$count.'" style="display:inline">'.$this->show_SubPages($this->subPage_type).'</form>';
    }

    /*
      __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。
     */

    function __destruct() {
        unset($each_disNums);
        unset($nums);
        unset($current_page);
        unset($sub_pages);
        unset($pageNums);
        unset($page_array);
        unset($subPage_link);
        unset($subPage_type);
    }

    /*
      show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页
     */

    function show_SubPages($subPage_type) {
        if ($subPage_type == 1) {
            return $this->subPageCss1();
        } elseif ($subPage_type == 2) {
            return $this->subPageCss2();
        } elseif ($subPage_type == 3) {
            return $this->subPageCss3();
        }
    }

    /*
      用来给建立分页的数组初始化的函数。
     */

    function initArray() {
        for ($i = 0; $i < $this->sub_pages; $i++) {
            $this->page_array[$i] = $i;
        }
        return $this->page_array;
    }

    /*
      construct_num_Page该函数使用来构造显示的条目
      即使：[1][2][3][4][5][6][7][8][9][10]
     */

    function construct_num_Page() {
        if ($this->pageNums < $this->sub_pages) {
            $current_array = array();
            for ($i = 0; $i < $this->pageNums; $i++) {
                $current_array[$i] = $i + 1;
            }
        } else {
            $current_array = $this->initArray();
            if ($this->current_page <= 3) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $i + 1;
                }
            } elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1) {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = ($this->pageNums) - ($this->sub_pages) + 1 + $i;
                }
            } else {
                for ($i = 0; $i < count($current_array); $i++) {
                    $current_array[$i] = $this->current_page - 2 + $i;
                }
            }
        }

        return $current_array;
    }

    /*
      构造普通模式的分页
      共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页]
     */

    function subPageCss1() {
        $subPageCss1Str = "";
        $subPageCss1Str.="共" . $this->nums . "条记录，";
        $subPageCss1Str.=$this->paginationLength_select($this->limit);
        //$subPageCss1Str.="每页显示" . $this->each_disNums . "条，";
        $subPageCss1Str.="当前第" . $this->current_page . "/" . $this->pageNums . "页 ";
        if ($this->current_page > 1) {
            $firstPageUrl = $this->url(1);
            $prewPageUrl = $this->url($this->current_page - 1);
            $subPageCss1Str.="[<a href='$firstPageUrl'>首页</a>] ";
            $subPageCss1Str.="[<a href='$prewPageUrl'>上一页</a>] ";
        } else {
            $subPageCss1Str.="[首页] ";
            $subPageCss1Str.="[上一页] ";
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->url($this->pageNums);
            $nextPageUrl = $this->url($this->current_page + 1);
            $subPageCss1Str.=" [<a href='$nextPageUrl'>下一页</a>] ";
            $subPageCss1Str.="[<a href='$lastPageUrl'>尾页</a>] ";
        } else {
            $subPageCss1Str.="[下一页] ";
            $subPageCss1Str.="[尾页] ";
        }

        return $subPageCss1Str;
    }

    /*
      构造经典模式的分页
      当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页]
     */
    
    function subPageCss2() {
        
        
        $subPageCss2Str = "";
        $subPageCss2Str.="当前第" . $this->current_page . "/" . $this->pageNums . "页 ";
        $subPageCss2Str.=$this->paginationLength_select($this->limit);
        //$subPageCss2Str.="每页显示" . $this->each_disNums . "条 ";

        if ($this->current_page > 1) {
            $firstPageUrl = $this->url(1);
            $prewPageUrl = $this->url($this->current_page - 1);
            $subPageCss2Str.="[<a href='$firstPageUrl'>首页</a>] ";
            $subPageCss2Str.="[<a href='$prewPageUrl'>上一页</a>] ";
        } else {
            $subPageCss2Str.="[首页] ";
            $subPageCss2Str.="[上一页] ";
        }

        $a = $this->construct_num_Page();
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $subPageCss2Str.="[<span style='color:red;font-weight:bold;'>" . $s . "</span>]";
            } else {
                $url = $this->url($s);
                $subPageCss2Str.="[<a href='$url'>" . $s . "</a>]";
            }
        }

        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->url($this->pageNums);
            $nextPageUrl = $this->url($this->current_page + 1);
            $subPageCss2Str.=" [<a href='$nextPageUrl'>下一页</a>] ";
            $subPageCss2Str.="[<a href='$lastPageUrl'>尾页</a>] ";
        } else {
            $subPageCss2Str.="[下一页] ";
            $subPageCss2Str.="[尾页] ";
        }
        return $subPageCss2Str;
    }

    function subPageCss3(){
        $html = '<div class="paginator"><span class="count">共 <strong>'.$this->nums.'</strong> 条</span>';
        $html .= ' <input type="button" value="跳转" onclick="if (document.getElementById(\'jump_p\').value) location.href=\''.$this->url('').'\'+document.getElementById(\'jump_p\').value"/> <input id="jump_p" type="text" style="width:50px"/>页';
        if ($this->current_page > 1) {
            $firstPageUrl = $this->url(1);
            $prewPageUrl = $this->url($this->current_page - 1);
            $html.='<a title="首页" href="'.$firstPageUrl.'" class="after">首页</a>';
            $html.='<a title="上一页" href="'.$prewPageUrl.'" class="after">上一页</a>';
        }
        
        $a = $this->construct_num_Page();
        $query = $this->query;
        for ($i = 0; $i < count($a); $i++) {
            $s = $a[$i];
            if ($s == $this->current_page) {
                $html.='<span class="thispage">'.$s.'</span>';
            } else {
                $html.='<a href="'.$this->url($s).'">'.$s.'</a>';
            }
        }
        
        if ($this->current_page < $this->pageNums) {
            $lastPageUrl = $this->url($this->pageNums);
            $nextPageUrl = $this->url($this->current_page + 1);
            $html.='<a title="下一页" href="'.$nextPageUrl.'">下一页</a>';
            $html.='<a title="尾页" href="'.$lastPageUrl.'">尾页</a>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    function url($page = 1){
        $query = $this->query;
        $query['p'] = $page;
        return $this->subPage_link . '?'.http_build_query($query);
    }
    
    //选择每页显示多少条
    function paginationLength_select($option = null){
        $options = $this->limit_select;
        $s = '每页显示<select id="paginationSelect'.self::$count.'" name="paginationLength">';

        foreach ($options as $k=>$v){
            $s .= "<option value='{$k}'".(($option == $k)?' selected="selected"':'').">{$v}</option>";
        }
        $s .= '</select>条';
        
        $count = self::$count;
        $s .=<<<EOT
   <script type="text/javascript">
<!--
document.getElementById('paginationSelect{$count}').onchange = function(){
	document.getElementById('paginationForm{$count}').submit();
};
//-->
</script>
EOT;
        return $s;
    }
}

?>
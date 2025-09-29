<?php
$博客名 = "ShowMeBaby's Blog";
$GitHub用户名 = "ShowMeBaby";
$博客标语 = "路漫漫其修远兮,吾将上下而求索.";
$默认首页文章路径 = "./markdown/ABOUT/AboutMe.md";
$默认首页文章标题 = "AboutMe.md";
function 输出分类列表($markdown文件夹){
    $分类列表=scandir($markdown文件夹);
    // markdown文件夹下第一级为 文章分类名
    foreach($分类列表 as $分类名){
        // 过滤掉./和../路径
        if($分类名!=="."&&$分类名!==".."){
            $路径 = $markdown文件夹."/".$分类名;
            if(is_dir($路径)){
                输出文章分类($分类名,$路径);
            }
        }
    }
}
function 输出文章分类($分类名,$路径){
    echo "<div class=\"mdui-collapse-item\"><div class=\"mdui-collapse-item-header mdui-list-item mdui-ripple\"><div class=\"mdui-list-item-content\">$分类名</div><i class=\"mdui-collapse-item-arrow mdui-icon material-icons\">keyboard_arrow_down</i></div><div class=\"mdui-collapse-item-body mdui-list\">";
    输出分类下文章列表($路径);
    echo "</div></div>";
}
function 输出分类下文章列表($路径){
    // 输出文件夹中的MD文件元素
    $文件列表=scandir($路径);
    foreach($文件列表 as $文件){
        if($文件!=="."&&$文件!==".."&&pathinfo($文件, PATHINFO_EXTENSION)==="md"){
            $文件真实路径 = $路径."/".$文件;
            echo "<a data_blogurl=\"$文件真实路径\" data_name=\"$文件\" class=\"mdui-list-item mdui-ripple\" href=\"#\" data_type=\"markdown\" onclick=\"setBlogTxt(this)\">$文件</a>";
        }
    }
}
function 输出本机引用文件(){
    // USECDN变量使用范围(editormd.min.js)
    if(empty($_GET["uselocal"])){
        // CDN(若CDN失效,可放弃CDN改用下方对应的本机路径)
        echo <<<UseCDN
            <script>const USECDN = true;</script>
            <script src="https://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://cdn.bootcss.com/mdui/0.4.3/js/mdui.min.js"></script>
            <link rel="stylesheet" href="https://cdn.bootcss.com/mdui/0.4.3/css/mdui.min.css"/>
            <script src="https://cdn.bootcss.com/marked/0.3.3/marked.min.js"></script>
            <script src="https://cdn.bootcss.com/raphael/2.3.0/raphael.min.js"></script>
            <script src="https://cdn.bootcss.com/prettify/188.0.0/prettify.min.js"></script>
            <script src="https://cdn.bootcss.com/underscore.js/1.9.1/underscore-min.js"></script>
            <script src="https://cdn.bootcss.com/js-sequence-diagrams/1.0.4/sequence-diagram-min.js"></script>
            <script src="https://cdn.bootcss.com/flowchart/1.13.0/flowchart.min.js"></script>
        UseCDN;
    } else {
        // 本机引用路径
        echo <<<DontUseCDN
            <script>const USECDN = false;</script>
            <script src="./static/editor.md/lib/jquery.min.js"></script>
            <link rel="stylesheet" href="./static/mdui/css/mdui.min.css?v=0.4.3" />
            <script src="./static/mdui/js/mdui.min.js?v=0.4.3"></script>
            <script src="./static/editor.md/lib/marked.min.js"></script>
            <script src="./static/editor.md/lib/prettify.min.js"></script>
            <script src="./static/editor.md/lib/raphael.min.js"></script>
            <script src="./static/editor.md/lib/underscore.min.js"></script>
            <script src="./static/editor.md/lib/sequence-diagram.min.js"></script>
            <script src="./static/editor.md/lib/flowchart.min.js"></script>
        DontUseCDN;
    }
    // 没有CDN的引用
    echo <<<NoCDN
        <link rel="stylesheet" href="./static/editor.md/css/editormd.preview.min.css"/>
        <script src="./static/editor.md/lib/jquery.flowchart.min.js"></script>
        <script src="./static/editor.md/editormd.min.js"></script>
    NoCDN;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="/static/favicon.ico" type="image/x-icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="<?php echo $博客名;?>" content="v1.0" />
        <title><?php echo $博客名;?></title>
        <?php 输出本机引用文件();?>
    </head>
    <body class="mdui-drawer-body-left mdui-appbar-with-toolbar  mdui-theme-primary-indigo mdui-theme-accent-blue">
        <!-- 顶部标题栏 -->
        <header class="mdui-appbar mdui-appbar-fixed">
            <div class="mdui-toolbar mdui-color-theme">
                <span class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-drawer="{target: '#main-drawer', swipe: true}"><i class="mdui-icon material-icons">menu</i></span>
                <a href="#" class="mdui-typo-headline mdui-hidden-xs" id="header"><?php echo $博客名;?></a>
                <a href="#" class="mdui-typo-title"><?php echo $博客标语;?></a>
                <div class="mdui-toolbar-spacer"></div>
                <!-- Github图标 -->
                <a href="https://github.com/<?php echo $GitHub用户名;?>" target="_blank" class="mdui-btn mdui-btn-icon mdui-ripple mdui-ripple-white" mdui-tooltip="{content: '访问我的 Github'}">
                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewbox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve" class="mdui-icon" style="width: 24px;height:24px;">
                        <path fill-rule="evenodd" clip-rule="evenodd" fill="#ffffff" d="M18,1.4C9,1.4,1.7,8.7,1.7,17.7c0,7.2,4.7,13.3,11.1,15.5c0.8,0.1,1.1-0.4,1.1-0.8c0-0.4,0-1.4,0-2.8c-4.5,1-5.5-2.2-5.5-2.2c-0.7-1.9-1.8-2.4-1.8-2.4c-1.5-1,0.1-1,0.1-1c1.6,0.1,2.5,1.7,2.5,1.7c1.5,2.5,3.8,1.8,4.7,1.4c0.1-1.1,0.6-1.8,1-2.2c-3.6-0.4-7.4-1.8-7.4-8.1c0-1.8,0.6-3.2,1.7-4.4c-0.2-0.4-0.7-2.1,0.2-4.3c0,0,1.4-0.4,4.5,1.7c1.3-0.4,2.7-0.5,4.1-0.5c1.4,0,2.8,0.2,4.1,0.5c3.1-2.1,4.5-1.7,4.5-1.7c0.9,2.2,0.3,3.9,0.2,4.3c1,1.1,1.7,2.6,1.7,4.4c0,6.3-3.8,7.6-7.4,8c0.6,0.5,1.1,1.5,1.1,3c0,2.2,0,3.9,0,4.5c0,0.4,0.3,0.9,1.1,0.8c6.5-2.2,11.1-8.3,11.1-15.5C34.3,8.7,27,1.4,18,1.4z"></path>
                    </svg>
                </a>
            </div>
        </header>
        <!-- 侧滑栏 -->
        <div class="mdui-drawer" id="main-drawer">
            <!-- markdown列表 -->
            <div class="mdui-list" mdui-collapse="{accordion: true}" id="nav"><?php 输出分类列表("./markdown");?></div>
        </div>
        <!-- 内容栏 -->
        <div class="mdui-container doc-container">
            <!-- markdown标题 -->
            <h1 class="doc-title mdui-text-color-theme" id="article-title">AboutMe</h1>
            <!-- markdown内容 -->
            <div class="doc-chapter" id="article"></div>
        </div>
        <!-- <a target="_blank" rel="noopener noreferrer" href="http://www.beian.miit.gov.cn">陕ICP备18016129号-3</a> -->
    </body>
<script>
  ready();
  // 图省事直接模拟dom获取默认首页md文件
  function ready() {
    try {
      $(document).ready(function() {
        var objE = document.createElement("div");
        objE.innerHTML =
          "<a data_blogurl='<?php echo $默认首页文章路径; ?>' data_name='<?php echo $默认首页文章标题; ?>' data_type='markdown' ></a>";
        setBlogTxt(objE.childNodes[0]);
      });
    } catch (e) {
      /*若jquery报错一般是CDN炸了,此时改为使用本机引用*/
      window.location.href = window.location.href + "?uselocal=true";
    }
  };
  var articleCache = null;

  function setBlogTxt(obj) {
    obj = $(obj);
    var blogName = obj.attr("data_name");
    var blogURL = obj.attr("data_blogURL");
    var type = obj.attr("data_type"); 
    /* 缓存文章路径相同则不重复请求 */
    if (articleCache == blogURL) {
      return;
    } else {
      articleCache = blogURL;
    }
    $("#article-title").text(blogName);
    $("#article").html("loading . . .");
    $GET(blogURL, function(result) {
      $("#article-title").show();
      if (type == "markdown") {
        $("#article").html("");
        testEditormdView = editormd.markdownToHTML("article", {
          markdown: result,
          /* htmlDecode: true, // 开启 HTML 标签解析，为了安全性，默认不开启 */ 
          htmlDecode: "style,script,iframe",
          /* you can filter tags decode */
          /* toc             : false, */ 
          tocm: true,
          /* Using [TOCM] */ 
          /* tocContainer    : "#custom-toc-container", // 自定义 ToC 容器层 */
          /* gfm             : false, */ /* tocDropdown     : true, */
          /* markdownSourceCode : true, // 是否保留 Markdown 源码，即是否删除保存源码的 Textarea 标签 */
          emoji: true,
          taskList: true,
          tex: true,/* 默认不解析 */ 
          flowChart: true,/* 默认不解析 */
          sequenceDiagram: true /* 默认不解析 */
        });
      } else {
        $("#article-title").hide();
        $("#article").html(result);
      }
    });
  }

  function $GET(url, success, error) {
    $.ajax({
      type: "GET",
      url: url,
      async: false,
      success: function(result) {
        if (success) {
          success(result);
        }
      },
      error: function(err) {
        if (error) {
          error();
        } else {
          mdui.alert(err.responseJSON.message);
          console.error(url, "请求失败,markdown文件链接可能炸了");
        }
      }
    });
  }

  function $POST(url, data, headers, success, error) {
    $.ajax({
      type: "POST",
      url: url,
      async: false,
      headers: headers,
      data: data,
      success: function(result) {
        if (success) {
          success(result);
        }
      },
      error: function(err) {
        if (error) {
          error();
        } else {
          mdui.alert(err.responseJSON.message);
          console.error(url, "请求失败,markdown文件链接可能炸了");
        }
      }
    });
  }
</script>
</html>
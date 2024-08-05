#!/usr/bin/php
<?PHP

exec("rm -rf /usr/local/emhttp/plugins/taglibpage");

exec("mkdir -p /usr/local/emhttp/plugins/taglibpage");
if (!is_file("/boot/config/plugins/taglib/taglib.json")) {
    return;
}
//read json
$config = json_decode(file_get_contents("/boot/config/plugins/taglib/taglib.json"), true);
for ($i = 0; $i < count($config); $i++) {
    $cfg = $config[$i];

    $label = ucfirst($cfg["label_name"]);
    $address = $cfg["visit_url"];
    $open_mode = $cfg["open_mode"];
    $adaptive_layout = $cfg["adaptive_layout"];
    $width = $cfg["width"];
    $height = $cfg["height"];
    $sort = $cfg["sort"];

    $dupeTest = exec("find /usr/local/emhttp/plugins -name '$label.page'");
    if ($dupeTest) {
        $label = "{$label}_";
    }

    $pageLocation = 800 + $sort;

    $mainPage = "Menu='Tasks:$pageLocation'\nName='$label'\nType='xmenu'\nTabs='true'\nCode='f111'\n";
    file_put_contents("/usr/local/emhttp/plugins/taglibpage/$label.page", $mainPage);

    $randPageFileName = "/usr/local/emhttp/plugins/taglibpage/$label" . mt_rand() . ".page";
    if ($open_mode == 'new') {
        $subPage = "Menu='$label'\nTitle='$label'\n---\n<script>let newTab = window.open('$address','_blank');if (!newTab || newTab.closed || typeof newTab.closed=='undefined'){alert('访问地址异常请检查参数');}history.back();</script>";
        file_put_contents($randPageFileName, $subPage);
    } else {
        $subPage = "Menu='$label'\nTitle='$label'\n---\n";
        file_put_contents($randPageFileName, $subPage);
        $iframeA = "<iframe src='$address' style='width: $width;height: $height;' onload='";
        file_put_contents($randPageFileName, $iframeA, FILE_APPEND);
        if ($adaptive_layout == 'true') {
            $iframeB = 'function onWindowResize(){let e=window.document.getElementsByClassName("content shift");if(e.length>0){let t=window.getComputedStyle(e[0].querySelector(".title"));if(t){let i=window.innerHeight-(window.document.getElementById("header").offsetHeight+window.document.getElementById("menu").offsetHeight+(window.document.getElementById("footer")!=null?window.document.getElementById("footer").offsetHeight:26)+parseInt(t.getPropertyValue("height").replace("px",""),10)+parseInt(t.getPropertyValue("padding-top").replace("px",""),10)+parseInt(t.getPropertyValue("padding-bottom").replace("px",""),10)+parseInt(t.getPropertyValue("margin-top").replace("px",""),10)+parseInt(t.getPropertyValue("margin-bottom").replace("px",""),10)+30),n=parseInt(t.getPropertyValue("width").replace("px",""),10)+parseInt(t.getPropertyValue("padding-left").replace("px",""),10)+parseInt(t.getPropertyValue("padding-right").replace("px",""),10),d=window.document.querySelector(".content.shift iframe");d.style.width=n+"px",d.style.height=i+"px",d.style.border="0px"}}}window.addEventListener("resize",function(){clearTimeout(window.resizedFinished),window.resizedFinished=setTimeout(onWindowResize,200)});onWindowResize();';
            file_put_contents($randPageFileName, $iframeB, FILE_APPEND);
        }
        $iframeC = "this.contentWindow.focus();'></iframe>";
        file_put_contents($randPageFileName, $iframeC, FILE_APPEND);
    }
}
?>

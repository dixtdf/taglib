<?PHP

function read_json_file($file)
{
    $json = @file_get_contents($file);
    if (!$json) {
        $json = [];
    }
    return $json;
}

switch ($_POST['action']) {
    case 'getData':
        echo json_encode(json_decode(read_json_file("/boot/config/plugins/taglib/taglib.json")));
        break;
    case 'applyData':
        //持久化配置文件
        file_put_contents("/boot/config/plugins/taglib/taglib.json", json_encode(json_decode($_POST['settings']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        exec("/usr/local/emhttp/plugins/taglib/scripts/createPage.php");
        echo "applyData done";
        break;
}

?>

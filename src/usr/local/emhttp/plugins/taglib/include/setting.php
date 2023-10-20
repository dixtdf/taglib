<?PHP

switch ($_POST['action']) {
    case 'getData':
        $configFilePath = "/boot/config/plugins/taglib/taglib.json";
        if (!is_file($configFilePath)) {
            echo '[]';
            break;
        }else{
            $file_contents = file_get_contents($configFilePath);
            if ($file_contents !== false) {
                echo $file_contents;
            } else {
                echo '[]';
            }
            break;
        }
    case 'applyData':
        $configFilePath = "/boot/config/plugins/taglib/taglib.json";
        file_put_contents($configFilePath, json_encode(json_decode($_POST['settings']), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        exec("/usr/local/emhttp/plugins/taglib/scripts/createPage.php");
        echo "applyData done";
        break;
}

?>

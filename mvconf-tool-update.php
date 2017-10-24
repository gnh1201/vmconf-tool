<?php
ini_set('max_execution_time', 3600);

// request vaules
$postvars = $_POST;

if(empty($postvars['terms'])) {
    echo "자동생성에 동의하여 주십시오";
    exit;
}

// vm setting
$required_fields = array(
	"ipaddr" => "아이피가 설정되지 않았습니다.<br/>",
	"hostname" => "호스트 네임이 설정되지 않았습니다.<br/>",
	"domainname" => "도메인 이름이 설정되지 않았습니다.<br/>",
	"adminemail" => "관리자 이메일이 설정되지 않았습니다.<br/>"
);

// check variable
foreach($required_fields as $k=>$v) {
	if(!array_key_exists($k, $postvars)) {
		exit($v);
	}
}

// read vagrant file
$myfile = fopen("/var/www/public/masterbox/Vagrantfile", "r") or die("Unable to open file!");
$oldconf = fread($myfile, filesize("/var/www/public/masterbox/Vagrantfile"));
fclose($myfile);

// change vagrant file
$replaceconf = array(
	"192.168.33.10" => $postvars['ipaddr'],
	"scotchbox" => $postvars['hostname'],
    "K1ir5v2tNVhrmyHz" => $postvars['dbpassword'],
    "nNvEvKphXhHER7aC" => "http://" . $postvars['domainname'],
    "OmJXWUOArw07oPZR" => $postvars['adminemail'],
    "MbeCMUfAqxu0m0wB" => $postvars['hostname']
);
$newconf = $oldconf;
foreach($replaceconf as $k=>$v) {
	$newconf = str_replace($k, $v, $newconf);
}
$newconf .= "\r\n# created at " . date("Y-m-d h:i:s");

// copy data
$copy = run_rcopy("/var/www/public/masterbox", "/var/www/public/clones/" . $postvars['hostname']);
if($copy) {
    step1(); // step 1: write vagrantfile
    step2(); // step 2: write bootstrap.sh
    step3(); // step 3: config.inc.php
    step4(); // step 4: apache-vhost.conf
    
    echo "모든 작업을 완료하였습니다.";
} else {
    echo "파일 복사 과정에 문제가 있습니다.<br/>";
}

// step 1: write vagrantfile
function step1() {
    global $newconf, $postvars;
    
    $filename = "/var/www/public/clones/" . $postvars['hostname'] . "/Vagrantfile";
    $somecontent = $newconf;
    if(is_writable($filename)) {
        if (!$handle = fopen($filename, 'w')) {
             echo "Cannot open file ($filename)";
             exit;
        }

        if (fwrite($handle, $somecontent) === FALSE) {
            echo "Cannot write to file ($filename)";
            exit;
        }

        echo "Vagrantfile 설정 파일 생성에 성공하였습니다.<br/>";
        fclose($handle);
    } else {
        echo "Vagrantfile 쓰기방지 되어 있습니다.<br/>";
        exit;
    }
}

// step 2: write bootstrap.sh
function step2() {
    global $replaceconf, $postvars;

    // read bootstrap.sh
    $myfilepath = "/var/www/public/masterbox/bootstrap.sh";
    $myfile = fopen($myfilepath, "r") or die("Unable to open file!");
    $oldconf = fread($myfile, filesize($myfilepath));
    fclose($myfile);

    // change bootstrap.sh
    $newconf = $oldconf;
    foreach($replaceconf as $k=>$v) {
        $newconf = str_replace($k, $v, $newconf);
    }
    $newconf .= "\r\n# created at " . date("Y-m-d h:i:s");

    // write new bootstrap.sh
    $filename = "/var/www/public/clones/" . $postvars['hostname'] . "/bootstrap.sh";
    $somecontent = $newconf;
    if(is_writable($filename)) {
        if (!$handle = fopen($filename, 'w')) {
             echo "($filename) 파일을 열 수 없습니다.";
             exit;
        }

        if (fwrite($handle, $somecontent) === FALSE) {
            echo "$filename) 파일을 작성할 수 없습니다.";
            exit;
        }

        echo "bootstrap.sh 생성에 성공하였습니다.<br/>";
        fclose($handle);
    } else {
        echo "bootstrap.sh 쓰기방지 되어 있습니다.<br/>";
    }
}

// step 3: config.inc.php
function step3() {
    global $replaceconf, $postvars;

    // read config.inc.php
    $myfilepath = "/var/www/public/masterbox/public/config.inc.php";
    $myfile = fopen($myfilepath, "r") or die("Unable to open file!");
    $oldconf = fread($myfile, filesize($myfilepath));
    fclose($myfile);

    // change config.inc.php
    $newconf = $oldconf;
    foreach($replaceconf as $k=>$v) {
        $newconf = str_replace($k, $v, $newconf);
    }
    
    // write new config.inc.php
    $filename = "/var/www/public/clones/" . $postvars['hostname'] . "/public/config.inc.php";
    $somecontent = $newconf;
    if(is_writable($filename)) {
        if (!$handle = fopen($filename, 'w')) {
             echo "($filename) 파일을 열 수 없습니다.";
             exit;
        }

        if (fwrite($handle, $somecontent) === FALSE) {
            echo "$filename) 파일을 작성할 수 없습니다.";
            exit;
        }

        echo "config.inc.php 생성에 성공하였습니다.<br/>";
        fclose($handle);
    } else {
        echo "config.inc.php 쓰기방지 되어 있습니다.<br/>";
    }
}

// step 4: apache-vhost.conf
function step4() {
    global $replaceconf, $postvars;

    // read apache-vhost.conf
    $myfilepath = "/var/www/public/masterbox/apache-vhost.conf";
    $myfile = fopen($myfilepath, "r") or die("Unable to open file!");
    $oldconf = fread($myfile, filesize($myfilepath));
    fclose($myfile);

    // change apache-vhost.conf
    $newconf = $oldconf;
    foreach($replaceconf as $k=>$v) {
        $newconf = str_replace($k, $v, $newconf);
    }
    
    // write new apache-vhost.conf
    $filename = "/var/www/public/clones/" . $postvars['hostname'] . "/apache-vhost.conf";
    $somecontent = $newconf;
    if(is_writable($filename)) {
        if (!$handle = fopen($filename, 'w')) {
             echo "($filename) 파일을 열 수 없습니다.";
             exit;
        }

        if (fwrite($handle, $somecontent) === FALSE) {
            echo "$filename) 파일을 작성할 수 없습니다.";
            exit;
        }

        echo "apache-vhost.conf 생성에 성공하였습니다.<br/>";
        fclose($handle);
    } else {
        echo "apache-vhost.conf 쓰기방지 되어 있습니다.<br/>";
    }
}

// recursive copy
function rcopy($source, $dest){
    if(is_dir($source)) {
        $dir_handle=opendir($source);
        while($file=readdir($dir_handle)){
            if($file!="." && $file!=".."){
                if(is_dir($source."/".$file)){
                    $subdirs = explode("/", $dest."/".$file);
                    $mksubdir = "";
                    foreach($subdirs as $subdir) {
                        if($subdirs[0] == "") {
                            $mksubdir .= $subdir . "/";
                        } else {
                            $mksubdir .= "/" . $subdir;
                        }

                        if(!is_dir($mksubdir) && !is_file($mksubdir)){
                            mkdir($mksubdir, 0777);
                        }
                    }

                    rcopy($source."/".$file, $dest."/".$file);
                } else {
                    copy($source."/".$file, $dest."/".$file);
                }
            }
        }
        closedir($dir_handle);
    } else {
        copy($source, $dest);
    }
}

function run_rcopy($source, $dest) {
    rcopy($source, $dest);
    return true;
}

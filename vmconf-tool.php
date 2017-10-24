<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Virtual machine auto scriptor with Vagrant">
    <title>가상머신 설정 자동생성 도구</title>
    <link rel="stylesheet" href="css/pure-min.css" type="text/css">
    <link rel="stylesheet" href="css/side-menu.css" type="text/css">
    <!--[if lt IE 9]>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <![endif]-->
</head>
<body>

<div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#">VM SETTING</a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="#" class="pure-menu-link">설정하기</a></li>
                <li class="pure-menu-item"><a href="#" class="pure-menu-link">설정방법</a></li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="header">
            <h1>VM SETTING</h1>
            <h2>가상머신 설정 자동생성 도구</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">입력 항목</h2>
            <p>
                사용할 아이피, 사용할 호스트 이름, 사용할 도메인, 사용할 DB 비밀번호, 관리자 이메일
            </p>

            <form id="form_vmconf" class="pure-form pure-form-stacked" method="post" action="vmconf-tool-update.php">
                <fieldset>
                    <legend>항목 설정</legend>

                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-3">
                            <label for="ipaddr">아이피 설정</label>
                            <input name="ipaddr" id="ipaddr" class="pure-u-23-24 required" type="text" value="192.168.33.10" />
                        </div>

                        <div class="pure-u-1 pure-u-md-1-3">
                            <label for="hostname">호스트 이름</label>
                            <input name="hostname" id="hostname" class="pure-u-23-24 required" type="text" value="company" />
                        </div>

                        <div class="pure-u-1 pure-u-md-1-3">
                            <label for="domainname">사용할 도메인</label>
                            <input name="domainname" id="domainname" class="pure-u-23-24 required" type="text" value="master.example.org"/>
                        </div>
                        
                        <div class="pure-u-1 pure-u-md-1-3">
                            <label for="dbpassword">사용할 DB 비밀번호</label>
                            <input name="dbpassword" id="dbpassword" class="pure-u-23-24 required" type="text" value="example123" />
                        </div>

                        <div class="pure-u-1 pure-u-md-1-3">
                            <label for="adminemail">관리자 이메일</label>
                            <input name="adminemail" id="adminemail" class="pure-u-23-24 required" type="email" value="admin@example.org" />
                        </div>
                    </div>

                    <label for="terms" class="pure-checkbox">
                        <input name="terms" id="terms" type="checkbox" value="1"/> 자동 생성에 동의합니다.
                    </label>

                    <button type="submit" class="pure-button pure-button-primary">생성하기</button>
                </fieldset>
            </form>
            
            <!-- 유의사항 -->
            <h2 class="content-subhead">유의사항</h2>
            <p>
                각 개별 기관에 맞추어진 설정은 별도로 진행하여야 합니다.
            </p>
        </div>
    </div>
</div>

<script type="text/javascript">//<!--<![CDATA[
    document.getElementById("form_vmconf").onsubmit = function() {
        window.open("wait.html", "", "width=500,height=240");
    };
//]]>--></script>

</body>
</html>

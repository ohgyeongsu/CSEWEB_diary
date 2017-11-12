<?PHP
header("Content-Type: text/html; charset=UTF-8");
$host = "localhost";          // MySQL DB서버 host
$user = "cseweb";                  // MySQL DB서버 접속 id
$password = "cseweb2017";  // MySQL DB서버 접속 password
$dbname = "cseweb";       // MySQL DB명
$dbconn = mysqli_connect($host,$user,$password,$dbname);
if(!$dbconn) {
   echo("DB 연결 실패");
   exit;
}
//한글깨짐방지
mysqli_query($dbconn, "set session character_set_connection=utf8;");
mysqli_query($dbconn, "set session character_set_results=utf8;");
mysqli_query($dbconn, "set session character_set_client=utf8;");

//받은 회원정보 변수에 저장
$user_email = htmlspecialchars($_POST["email"]);
$user_password = htmlspecialchars($_POST["pw"]);
$user_name = htmlspecialchars($_POST["name"]);
$user_birth = htmlspecialchars($_POST["birthday"]);

//빈칸검사 결과 존재시
if($user_name==''|| $user_password==''|| $user_email=='' || $user_birth==''){
  echo '<script>alert("양식을 모두 채워주세요")
      history.back()</script>';
}
//빈칸검사 결과 없을시
else {
  //email 중복 여부 체크
  $tableemtpy = TRUE;
  $result = FALSE;
  $data = mysqli_query($dbconn,"select email from info");
  
  while($finddata = mysqli_fetch_assoc($data)){
    $tableemtpy = FALSE;
    //중복존재시
    if(!strcmp($user_email,$finddata["email"])){
      echo '<script>alert("같은 이메일이 존재합니다.")
      history.back()</script>';
    }
    //중복없을시
    else{
      $result = TRUE;
    }
  }
  //테이블이 empty일 경우
  if($tableemtpy) {
    $result = TRUE;
  }
  //중복이 없으면 회원정보 db에 저장
  if($result){
    $sql = "insert into info(email,password,name,birth,profile) values('$user_email','$user_password','$user_name','$user_birth','$profile')";
    if($dbconn->query($sql)){
      echo("<script>alert('회원가입 성공'); location.href='./index.html';</script>");
    }
    else{
      echo 'fail';
    }
  }
}
?>

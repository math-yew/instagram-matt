<?php
/*
Plugin Name: Instagram - Matt
Description: Navigate some info in Instagram
Author: Matt Mecham
Version: 1.0
*/
//
// $urls = array("https://www.instagram.com/p/CdMmh_upsB8/embed",
// "https://www.instagram.com/p/CdNJ_BFBrj8/embed");






// include 'simple_html_dom.php'; // If the library is in another folder you should do include 'path_to_library/simple_html_dom.php'
require __DIR__ . '/urls.php';

function sollus_styles() {
    wp_enqueue_style( 'sollus',  plugin_dir_url( __FILE__ ) . '/css/styles.css' );
}
add_action('wp_enqueue_scripts','sollus_styles');

function theme_options_panel(){
  /*
		Adding Menu to Main WordPress Side Menu
		add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null )
  */
  add_menu_page('Default Name', 'Default Name', 'manage_options', 'default-options', 'initialize_defaulplugin',plugins_url('/defaultname/img/icon.png',__DIR__));

  /*
		Adding Sub Menu to your Menu
		add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )
  */
  add_submenu_page( 'default-options', 'About', 'About', 'manage_options', 'default-about', 'default_about');
  add_submenu_page( 'default-options', 'FAQ', 'FAQ', 'manage_options', 'default-faq', 'default_faq');

}
add_action('admin_menu', 'theme_options_panel');

function initialize_defaulplugin(){
	echo "Hello World";
}
function default_about(){
	echo "About Page Here";
}
function default_faq(){
	echo "FAQ Page Here";
}

function sollus_move_from_left($atts, $content){
    $newContent = '<div class="hide-mdm-from-left">'. $content . '</div>';
    return $newContent;
  }
add_shortcode('move-from-left', 'sollus_move_from_left');

function sollus_move_from_right($atts, $content){
    $newContent = '<div class="red-text hide-mdm-from-right">'. $content . '</div>';
    return $newContent;
  }
add_shortcode('move-from-right', 'sollus_move_from_right');

function mattTest($atts, $content){
    $newContent = '<p class="red-text hide-mdm-from-right">Matt Test Working'.$content.'</p>';
    return $newContent;
  }
add_shortcode('matt-test', 'mattTest');

function getData(){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "site1";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT umeta_id, meta_key, meta_value FROM s1_usermeta";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
      echo "<table  style='width:200px'><tr><th>ID</th><th>Name</th></tr>";
      while($row = $result->fetch_assoc()) {
          echo "<tr><td style='width:100px'>" . $row["id"]. "</td><td style='width:100px'>" . $row["meta_key"]. " " . $row["meta_value"]. "</td></tr>";
      }
      echo "</table>";
  } else {
      echo "0 results";
  }
  $conn->close();
}


$matt = "mecham";
function lookAtPage($urls){
  echo $matt;
  foreach($urls as $u){
    getInfo($u);
  }
  echo "<br>";
  echo "Finished";
}

lookAtPage($urls);

function getInfo($url){
  $html = file_get_contents($url."embed");
  // echo '"'.substr($html,500,$len).'"';
  // $len = strlen($html);
  echo "<br>";
  echo "<br>";
  echo "URL: ".$url;
  echo "<br>";

  $userReg = "/UsernameText\">.*</";
  preg_match_all($userReg, $html, $userRes);
  $userName = preg_replace("/(UsernameText\">|<)/","",$userRes[0][0]);
  echo "<br>";
  echo "User Name: ".$userName;
  echo "<br>";

  $followReg = "/\D\d(\d|[.,KM])+\s?followers/i";
  preg_match_all($followReg, $html, $followRes);
  $followers = preg_replace("/[^KM.\d]/i","",$followRes[0][0]);
  echo "# Followers: ".$followers;
  echo "<br>";
  if(preg_match("/K/", $followers)){
    echo "true";
    postData($userName,$followers,$url);
  }
}

function postData($name,$followers,$url){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "site1";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "INSERT INTO influencers (name, followers, url)
  VALUES ('".$name."', '".$followers."', '".$url."')";

  if ($conn->query($sql) === TRUE) {
    echo "<br>";
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  echo "";
  $conn->close();
}

function getDatabase(){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "site1";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT name, followers  FROM influencers";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      echo "<table  style='width:200px'><tr><th>ID</th><th>Name</th></tr>";
      // output data of each row
      while($row = $result->fetch_assoc()) {
          echo "<tr><td style='width:100px'>" . $row["name"]. "</td><td style='width:100px'>" . $row["followers"]. "</td></tr>";
      }
      echo "</table>";
  } else {
      echo "0 results";
  }
  $conn->close();
}

?>



<script src="script.js" type="text/javascript"></script>

<script>
var styles = `
    header {
        display:none;
    }
`;
var styleSheet = document.createElement("style");
styleSheet.innerText = styles;
document.head.appendChild(styleSheet);
  // alert("test");
/*
  let winHeight = window.innerHeight;

  let loaded = false;
  window.onload = (event) => {
    let sols = document.querySelectorAll('[class*="-mdm-"]');
    [...sols].map(e=>{
      [...e.classList].map((c)=>{
        if(c.indexOf("-mdm-") > -1){
          let newClass = c.split("-mdm-");
          e.classList.add("sol-" + newClass[0]);
          e.classList.add("mdm");
        }
      });
    })
    loaded = true;
  };

    window.addEventListener('scroll', function() {
      if(loaded){
        let winScroll = window.scrollY;
        // document.querySelectorAll('[class*="-mdm-"]').forEach((e)=> {
        document.querySelectorAll('.mdm').forEach((e)=> {
          let bound = e.getBoundingClientRect();
          let position = bound.top - winHeight*.75;
          // console.log(position);
          if(position < 0){
          // if(position < 0 || (window.innerHeight + window.pageYOffset) >= document.body.offsetHeight){
            [...e.classList].map((c)=>{
              console.log("triggered");
              if(c.indexOf("-mdm-") > -1){
                let newClass = c.split("-mdm-");
                e.classList.remove("sol-" + newClass[0]);
                e.classList.add("sol-" + newClass[1]);
                e.classList.remove("mdm");
              }
            });
          }
        });
      }
    });
*/
</script>

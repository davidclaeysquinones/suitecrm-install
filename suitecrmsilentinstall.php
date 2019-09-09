<?php

/*
 * php suitecrmsilentinstall.php --install_location /var/www/html/suitecrmpath --db_host localhost --db_user dbuser --db_pass dbpass --db_name dbname --site_username admin --site_pass password --site_host example.com --site_name "SuiteCRM Silent Install"
 */
$args = getArguments();
echo "args : " $args;
createConfigFile($args);
$url = "http://".$args['site_host']."/install.php?goto=SilentInstall&cli=true";
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$results = curl_exec($ch);
$matches = array();
preg_match("/<bottle>(.*)<\/bottle>/s",$results,$matches);
echo "Install message was: ".$matches[1]."\n";

function getCLIArguments(){
  return getopt("",array("install_location:","db_host:","db_user:","db_pass:","db_name:","site_username:","site_pass:","site_host:","site_name:"));
}

function getArguments(){
  return getCLIArguments();
}

function createConfigFile($args){
    $installLoc = $args['install_location'];
    $config = createConfigArray($args);
    echo var_export($config,1);
    /*$contents = '<?php'."\n".'$sugar_config_si = '.var_export($config,1).";\n";
    file_put_contents($installLoc.'/config_si.php',$contents);*/
}

function createConfigArray($args){
  $dbUser = $args['db_user'];
  $dbPass = $args['db_pass'];
  $dbName = $args['db_name'];
  $dbHost = $args['db_host'];
  $siteUserName = $args['site_username'];
  $siteUserPass = $args['site_pass'];
  $siteHost = $args['site_host'];
  $siteName = $args['site_name'];
  $configArr = array (
    'dbUSRData' => 'create',
    'default_currency_iso4217' => 'USD',
    'default_currency_name' => 'US Dollar',
    'default_currency_significant_digits' => '2',
    'default_currency_symbol' => '$',
    'default_date_format' => 'Y-m-d',
    'default_decimal_seperator' => '.',
    'default_export_charset' => 'ISO-8859-1',
    'default_language' => 'en_us',
    'default_locale_name_format' => 's f l',
    'default_number_grouping_seperator' => ',',
    'default_time_format' => 'H:i',
    'export_delimiter' => ',',
    'setup_db_admin_password' => $dbPass,
    'setup_db_admin_user_name' => $dbUser,
    'setup_db_create_database' => 1,
    'setup_db_database_name' => $dbName,
    'setup_db_drop_tables' => 0,
    'setup_db_host_name' => $dbHost,
    'setup_db_pop_demo_data' => false,
    'setup_db_type' => 'mysql',
    'setup_db_username_is_privileged' => true,
    'setup_site_admin_password' => $siteUserPass,
    'setup_site_admin_user_name' => $siteUserName,
    'setup_site_url' => $siteHost,
    'setup_system_name' => $siteName,
  );
  return $configArr;
}

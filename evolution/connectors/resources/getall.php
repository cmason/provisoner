<?php
/**
 * Provisoner all resources evolution component
 *
 * @category  Provisioning
 * @author    S. Hamblett <steve.hamblett@linux.com>
 * @copyright 2010 S. Hamblett
 * @license   GPLv3 http://www.gnu.org/licenses/gpl.html
 * @link      none
 *
 * @package provisioner
 *
 *
 */

$resourceArray = array();

/* Protection */
if(REVO_GATEWAY_OPEN != "true") die("Revo Gateway API error - Invalid access");

/* Get the resources from the database */
$db = mysql_connect($database_server, $database_user, $database_password);
if (!$db) die("Revo Gateway API error - No server :- $database_server, $databse_user, $databse_password");

$dbase = str_replace('`', '', $dbase);
$db_selected = mysql_select_db($dbase, $db);
if (!$db_selected) die ("Revo Gateway API error - No database :- $dbase");

$sql = "SELECT * FROM " . $table_prefix . "site_content ";

$result = mysql_query($sql, $db);
if (!$result) die("Revo Gateway API error - Invalid Resource query");

while ($resource = mysql_fetch_assoc($result)) {

    /* UTF8 encode character fields */
    $resource['pagetitle'] = utf8_encode($resource['pagetitle']);
    $resource['longtitle'] = utf8_encode($resource['longtitle']);
    $resource['description'] = utf8_encode($resource['description']);
    $resource['alias'] = utf8_encode($resource['alias']);
    $resource['introtext'] = utf8_encode($resource['introtext']);
    $resource['content'] = utf8_encode($resource['content']);
    $resource['menutitle'] = utf8_encode($resource['menutitle']);

    $resource['class_key'] = 'modDocument';
    $resourceArray[] = $resource;

}

$response = errorSuccess('',$resourceArray);
mysql_close($db);
echo toJSON($response);
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

$conn = ldap_connect('10.106.76.133') or die("Failed to connect to ldap server.");

ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

ldap_bind(	$conn, 
			"cn=Administrateur,cn=Users,dc=universpneus,dc=local",
			"eclipse@9") 
	or die("Failed to bind to ldap server: " + ldap_error($conn));

print("Successful LDAP bind.");

/*
 * 
To enable php ldap module in XAMPP, find the following files and copy them in windows/system32
libeay32.dll/libsasl.dll/ssleay32.dll/
uncomment “extension=php_ldap.dll” in php.ini ;restart"

OpenLDAP is a free suite of client and server tools that implement the Lightweight Directory Access Protocol (LDAP)
https://www.userbooster.de/en/download/openldap-for-windows.aspx
 */
?>
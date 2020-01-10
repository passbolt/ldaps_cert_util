<?php
require('./vendor/autoload.php');
use LdapTools\Utilities\LdapUtilities;

// You can edit the configuration below with your own ldap host.
$ldapServerHost = 'host.yourldapdomain.com';

// Uncomment this for more debug information.
// ldap_set_option(null, LDAP_OPT_DEBUG_LEVEL, 7);

$certificates = LdapUtilities::getLdapSslCertificates($ldapServerHost);

$bundle = $certificates['peer_certificate'];
foreach($certificates['peer_certificate_chain'] as $cert) {
    $bundle .= $cert;
}

echo $bundle;
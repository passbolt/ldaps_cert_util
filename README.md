# LDAPS CERT UTIL
Small utility to retrieve the different parts of a ldaps certificate and bundle them together, and get passbolt
to work with ldaps.

## How to use?
On your passbolt server (or any other server with a ldaps certificate issue), [get composer](https://getcomposer.org/download/) then install project dependencies:

```shell
./composer.phar install
```

Edit the php script configuration with your host name. Replace `host.yourldapdomain.com` in the line `$ldapServerHost = 'host.yourldapdomain.com';`

Then, we run the command.

```shell
php ./get_certificate.php
```

At this point, the command should display a bundle certificate.

Let's copy the certificate where we need it:

```shell
php ./get_certificate.php | sudo tee /etc/ssl/certs/ldaps_bundle.crt
```

Ensure the certificate has correct rights (any user should be able to read the certificate):

```shell
sudo chown root:root /etc/ssl/certs/ldaps_bundle.crt
sudo chmod 644 /etc/ssl/certs/ldaps_bundle.crt
```

Finally, we edit the ldap.conf config file

```shell
nano /etc/ldap/ldap.conf
```
*(The ldap.conf file can also be found in /etc/openldap/ldap.conf)*

And we edit the line starting with `TLS_CACERT` to point to our new certificate:

```
TLS_CACERT /etc/ssl/certs/ldaps_bundle.crt
```

That's it. The LDAPS connection should now work.

## How to debug
The ldapsearch command is here to help (from the ldap-utils package on debian)

> As passbolt will connect to your LDAP server as the web user, it is important to execute the ldapsearch command as this user (`www-data` for Debian/Ubuntu, `wwwrun` for openSUSE, `nginx` for RHEL based Linux distributions) and **not as root user**

Example:

```shell
sudo su -s /bin/bash -c 'ldapsearch -x -D "username" -W -H ldaps://your_ldap_host -b "dc=domain,dc=ext" -d 9' www-data
```

## Credits
This work is just a ready to use version of the very detailed documentation provided by ldaptools: https://github.com/ldaptools/ldaptools/blob/master/docs/en/cookbook/Getting-Your-LDAP-SSL-Certificate.md
Kudos to them for their great work.


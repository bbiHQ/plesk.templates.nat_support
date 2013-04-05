PROBLEM
=======
Running Plesk Panel behind NAT creates a unique problem where the server isn't aware of its public IPs. This creates headaches especially if you have a multiple IPs setup on Amazon Web Service (AWS) with elastic IPs. Parallel's official [document](http://download1.parallels.com/Plesk/PP11/11.5/Doc/en-US/online/plesk-administrator-guide/index.htm?fileName=64949.htm) and [KB](http://kb.parallels.com/1984) suggested that you use the private IPs and manually update each of the DNS records so that the respective pubic IPs are used.

The cause of this problem is due to the fact that Plesk generates the mail, apache, and nginx using a template based on your IPs. It also uses another set of scripts to generate DNS records based on these IPs. In order for hosting, mail etc to work, the resolving IPs have to be those behind NAT (private IPs) and yet the DNS, which are used for domain resolving, has to be generated by publiclly accessiable IPs.

If private IPs are used, as suggested by Parallels, it will cause the following problems:

1. DNS records have to be manually generated for every new domain / subdomain.
2. Users of the panel will always see the private IPs without knowing their public IPs and will cause a lot of confusions.

This set of custom tempaltes will allow public IPs to be used, and seen by users and DNS record generators. Since public IPs is used throughout the system, DNS records can be generated as is and users will see their real public IPs. A special function ```nat_resolve``` is used when the hosting scripts are generated, converting all public IPs to their respective private IPs.

DEPLOYMENT
==========
1. Log in to Plesk Panel as admin and add (Tools & Settings > IP Addresses) all private IPs to the server with the subnet mask of 255.255.255.0 and best to mark them as dedicated.
2. Add all public IPs to the server with the subnet mask of 255.255.255.255.
3. Assign / move all subscriptions to the public IPs only. Private IPs shall not be used from now on.
4. Copy these template set into ```/usr/local/``` folder. Making the new custom scripts available at ```/usr/local/psa/admin/conf/templates/custom```.
5. Modify the ```$nat_translation``` arrat in the ```nat_translation_db.php``` file located at ```/usr/local/psa/admin/conf/templates/custom/lib```. Mapping all public IPs to private IPs.
6. Ask Plesk to regenerate all the scripts. Parallels's offical [document](http://download1.parallels.com/Plesk/PP11/11.0/Doc/en-US/online/plesk-linux-advanced-administration-guide/index.htm?fileName=68693.htm) recommend ```/usr/local/psa/admin/bin/httpdmng --reconfigure-all``` to be called as root via terminal / ssh.

METHOD
======
* update ```...->escapedAddress``` to ```nat_resolve(...->escapedAddress)```

RESOURCES
=========
You can change the settings of virtual hosts running on the Panel server, for example, set custom error pages (similar for all virtual hosts), or change the port on which the hosted site is available.

To reduce the risk of errors during modification of configuration files, Parallels Plesk Panel provides a mechanism for changing virtual host configuration - configuration templates. Before 11.0 Panel had templates only for Apache configuration files, but with adding support for nginx administrators can modify nginx templates as well. Read more about the how Apache and nginx work together in the Administrator's Guide, section Improving Web Server Performance with nginx (Linux).

* [Changing Virtual Hosts Settings Using Configuration Templates](http://download1.parallels.com/Plesk/PP11/11.0/Doc/en-US/online/plesk-linux-advanced-administration-guide/index.htm?fileName=68693.htm)
* [Apache Configuration Variables](http://download1.parallels.com/Plesk/PP11/11.0/Doc/en-US/online/plesk-linux-advanced-administration-guide/index.htm?fileName=68713.htm)
* [Configuration Templates Structure](http://download1.parallels.com/Plesk/PP11/11.0/Doc/en-US/online/plesk-linux-advanced-administration-guide/index.htm?fileName=68820.htm)

NOTES
=====
* run ```/usr/local/psa/admin/bin/httpdmng --reconfigure-all``` after changes are made to recompile all existing configs
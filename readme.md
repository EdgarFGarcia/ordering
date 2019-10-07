Introduction
============

Guest Helpdesk

Installation
------------

- Clone the repository

```
cd /usr/share/nginx/html

git clone ssh://vcs-user@phabricator.victoriacourt.biz:2222/source/guesthelpdesk.git
```

Laravel
------------
- On the folder project
```
cd guesthelpdesk

chmod 777 -R bootstrap/ storage/
```

NGINX
------------
- sudo vim /etc/nginx/sites-available/default

```
location ^~ /guesthelpdesk {
    alias /usr/share/nginx/html/guesthelpdesk/public;
    try_files $uri $uri/ @guesthelpdesk;
    location ~ \.php {
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include /etc/nginx/fastcgi_params;
    }
}
location @guesthelpdesk {
    rewrite /guesthelpdesk/(.*)$ /guesthelpdesk/index.php?/$1 last;
}
```

- Save and exit.

- Check NGINX for errors

```
sudo nginx -t
```

- If there are no errors, restart NGINX

```
sudo service nginx restart
```

Browser Support
---------------
- Chrome (latest)
- Safari (latest)
- Firefox (latest)
- Opera (latest)
- IE 9+

Bugs / Feature Requests
-------
Please file bugs and Feature Requests here [http://phabricator.victoriacourt.biz/maniphest/](http://phabricator.victoriacourt.biz/maniphest/).

Credits
-------------
Nerdvana

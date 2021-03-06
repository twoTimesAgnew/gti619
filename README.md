# GTI619

## Technical Specs
This project uses the following technologies:
* Docker CE (`version 18.05.0-ce, build f150324`)
* PHP (`version 7.2.7`)
* Laravel (`version 5.6.27`)
* MariaDB (`version 10.3.17`) &rarr; There are currently issues with mysql 8+ and Laravel
* Redis (`version 4.0.10`)

Tested on `Ubuntu 16.04 LTS and Ubuntu 18.04`  
#### Side Note
I recommend running this project on a Linux distro as the latest version of Docker For Windows  
has a pretty serious memory leak when deploying a stack (like in this project). 

## Requirements

### Docker CE

The only thing required to run this project is Docker CE. If you're on Windows (you shouldn't be)  
simply go to [the following url](https://store.docker.com/editions/community/docker-ce-desktop-windows "Docker Store"), create an account and download for free.  
  
If you're on ArchLinux (looking at you Guillaume) then have fun following [this link.](https://wiki.archlinux.org/index.php/Docker#Installation "ArchLinux Docker Installation")  
  
  
If you're on a normal Debian Linux installation then do the following:  
##### Update packages
```
$ sudo apt-get update
```
##### Install required utils
```
$ sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    software-properties-common
```    
##### Get the repository key
```
$ curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
```
##### Add the repository
```
$ sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
```
##### Update packages
```
$ sudo apt-get update
```
##### Install docker
```
$ sudo apt-get install docker-ce
```
##### Add yourself to docker group to avoid sudo on every command
```
$ sudo usermod -aG docker $USER
```
Restart the VM. If you're not in a VM, logout and log back in.
##### Check the docker version
```
$ docker --version
Docker version 18.05.0-ce, build f150324
```

## Project Setup

##### Clone the project from github  
```
$ git clone http://github.com/twotimesagnew/gti619.git
```

##### cd into the directory or open the project in an IDE  
```
$ cd /path/to/project
````

##### Open local_stack.yml file, and modify the source path to the project path that you just cloned:
```yaml
ui:
volumes:
      - type: bind
        source: /path/to/gti619/ui
        target: /var/www/html
```
**DO NOT TOUCH TARGET, ONLY SOURCE**

##### Initialize the docker swarm:  
```
$ docker swarm init
```

## Deploying our stack:  

```
$ docker stack deploy -c local_stack.yml gti
```  
The installation will take a long time the first time because all of the images need to be downloaded. You can  
track the progress by running `watch docker images`. Once you have mariadb, redis, laravel and phalcon, they  
will start running composer install which will install the dependencies for both frameworks. This will also  
take a long time. **Expect to wait ~10 mins the first time.** Re-deployments after the first one will be  
almost instantaneous.

##### Once all images are downloaded, check the status by running:  
```
$ docker service ls
```  
All services should be showing `1/1` in the **Replicas** field

##### If you need to check logs for a specific service, you can run the following:  
```
$ docker service logs <service_name> -f
```  
This will show you all the `stdout` and `stderr` output.  
For example, `docker service logs gti_ui -f` will show everything happening as if you were checking laravel logs

##### You should now be able to reach the services at:
```text
mysql : localhost:3306
php   : localhost:8080
redis : localhost:6379
```

## N.B.

Since we are binding our code, if you change something in your project, you do not need  
to re-deploy the stack. The changes will be applied automatically. Simply refresh the webpage and you should  
see your changes reflected.  
  
The only times you will need to redeploy will be if you modify something in the `local_stack.yml` file. For  
example, if you want to test in a production environment, you could set `APP_ENV: production` and you would  
need to rebuild.

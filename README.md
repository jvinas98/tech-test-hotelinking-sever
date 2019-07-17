# Manual de instalación

Para arrancar el servidor utilizaremos [Homestead](https://laravel.com/docs/5.8/homestead).
Laravel Homestead es un paquete [Vagrant](https://www.vagrantup.com/) preempaquetado oficial que ofrece un entorno de desarrollo sin necesidad de 
instalar PHP, un servidor web y cualquier otro software de servidor en su máquina local.

Para poder ejecutar el entonrno necesitaremos:
* [Vagrant](https://www.vagrantup.com/downloads.html)

* [VirtualBox](https://www.virtualbox.org/wiki/Downloads): En windows se debe la activar virtualizacion por hardware en la 
bios para que funcione VirtualBox

Primero debemos importar la caja de Homestead, para ello ejecutaremos el siguiente comando:

```
vagrant box add laravel/homestead
```
Nos aparecerá que proveedor queremos usar, marcaremos VirtualBox.

A continuación procedemos a instalar Homestead en nuestro equipo local:

```
cd ~

git clone https://github.com/laravel/homestead.git Homestead


cd Homestead

```

Dependiendo el sistema operativo ejecutaremos diferentes scripts.

Ubuntu 
```
bash init.sh
```

Windows
```
.\init.bat  
```

La configuración de Homestead se encuentra en **Homestead.yaml**

Dejo la configuración que he usado yo aquí.
```
ip: "192.168.10.10"
memory: 2048
cpus: 2
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/code
      to: /home/vagrant/code

sites:
    - map: homestead.test
      to: /home/vagrant/code/tech-test-hotelinking-sever/public

databases:
    - homestead

features:
    - mariadb: false
    - ohmyzsh: false
    - webdriver: false
    
```
### A tener en cuenta
En ``folders:`` se define donde estrá ubicado el directorio local (nustro ordenador) y el remoto (la máquina virtual).
Por esa razón en ``map:`` se indica donde estara nuestro directorio local por lo tanto debe existir en nuetro ordenador,
en mi ejemplo el directorio se ubica en el home del usuario.
Para crear el directorio ejecute los siguientes comandos:
```
cd ~
mkdir code
```
     
Importante el apartado de la clave ssh, debemos crear una para poder utilizar vagrant.
En mi configuración ``keys:`` apunta a ``~/.ssh/id_rsa`` que es donde se generán las claves por defecto.

Una vez confiurado el fichero ``Homestead.yaml`` iniciaremos Homestead con el siguiente comando.
```
vagrant up
```

Por otra parte, debemos añadir a nuestro host la ip configurada en el archivo Homestead.yaml , en ununtu/mack se 
encuentra en ``/etc/hosts``, en windows se ecnuentra en ``C:\Windows\System32\Drivers\etc``, debemos poner en el 
archivo **hosts** lo siguiente:

```
Esta es la ip configurada en el archivo Homestead.yaml
192.168.10.10 hotelinking.test
```

Para acceder via ssh, debemos introducir ``vagrant shh`` dentro del directorio donde hemos clonado el 
repositiorio de Homestead.


Dentro de nuetra máquina crearemos las bases de datos necesarias.

Para acceder a mysql introduciremos 
```
mysql -uroot -p
```
Contraseña
```
secret
```

Dentro de mysql ejecutaremos.

```
create schema hotelinkingDB;
create schema hotelinkingDBTest;
exit;
```

Es hora de clonar el repositorio, dentro de la máquina virtual ejecutaremos lo siguiente.

```
cd /home/vagrant/code/ 
git clone https://github.com/jvinas98/tech-test-hotelinking-sever.git
cd tech-test-hotelinking-sever
```

Una vez dentro instalaremos las dependencias con 
```
composer install
```

Cuando finalize procederemos a configurar el archivo ``.env``.
Primero debemos crearlo.
```
cp .env.example .env
```

Despues debemos generar la ``APP_KEY``

```
 php artisan key:generate
```

Ahora debemos hacer la conexión de la base de datos, para ello entratemos en el fichero recien creado ``.env``.
Modificaremos estos parametros 
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotelinkingDB
DB_USERNAME=root
DB_PASSWORD=secret
```
Si se ha creado la base de datos como se explica aquí no deberá hacer nada mas, si se ha creado con otro nombre 
debera cambiar el nombre en ``DB_DATABASE``.

Ahora procederemos a migrar la base de datos, esta api utiliza [laravel passport](https://laravel.com/docs/5.8/passport)
para la autenticación.
Ejecutaremos lo siguiente:
```
php artisan migrate
php artisan passport:install
php artisan db:seed
```

Ya tenemos nuestro servidor funcionando.
Para poder verlo en acción puede instalar [tech-test-hotelinking-frontend](https://github.com/jvinas98/tech-test-hotelinking-frontend)

# Test

Si se han creado las bases de datos, tanto ``hotelinkingDB`` como ``hotelinkingDBTest``. Unicamente ejecute ``phpunit``. 
En el directorio donde se encuentra el proyecto.

Si no tiene la base de datos con el nombre ``hotelinkingDBTest`` puede crearla o puede modificar el archivo ``phpunit.xml``.



## API REST LARAVEL 8 

Este proyecto de una API REST con Laravel 8, se utiliza JWT-AUTH (JSON Web token) para la creación de token de acceso. En este proyecto encontraras un ejercicio CRUD sencillo para listar, crear, actualizar y eliminar Cuadros de un Museo.

## INSTALACIÓN

Para poder utilizar está API sigue estos pasos:

- Clonar o descargar este repositorio en la carpeta de su proyecto.
- Dentro del proyecto habrá la terminal y con [Composer ](https://getcomposer.org/) realice la instalación (composer install).
- Configure su archivo .env (revise la configuración de la DB).
- Crear la base de datos
- Generar la APP_KEY, esto lo realiza desde la terminal (php artisan key:generate)
- Generar las migraciones correspondientes también desde la terminal (php artisan migrate).

LISTO!

## USAR

Crear un usuario para utilizar la API.
[POST] - http://127.0.0.1:8000/api/auth/register

        email: "useremail@domain.com"
        password: "userpassword"
        password_confirmation: "userpassword"
        name: "nameuser"


![Screen Shot 2022-05-11 at 12 49 55](https://user-images.githubusercontent.com/101833936/167897669-96dfc6de-8173-4ec2-8f33-38a0e50796e8.png)
--
Login de usuario se obtiene el bearer token [POST] http://127.0.0.1:8000/api/auth/login?email=i.cristianbrito@gmail.com&password=12345678

        email: "useremail@domain.com"
        password: "userpassword"

![Screen Shot 2022-05-11 at 15 06 08](https://user-images.githubusercontent.com/101833936/167917193-161899a8-cf8a-47ce-8f71-5a465376621d.png)
--
Ahora que genero el token después de login puede realizar el CRUD.

![Screen Shot 2022-05-11 at 15 36 20](https://user-images.githubusercontent.com/101833936/167922292-d5152a8f-d35c-41c9-bee3-c3c3b0f5a191.png)

Crear un nuevo registro [POST] http://127.0.0.1:8000/api/pictures?name=La noche estrallada&painter=V V Gogh&country=Estados Unidos
![Screen Shot 2022-05-11 at 15 43 22](https://user-images.githubusercontent.com/101833936/167923051-2f8fabca-7a59-46a4-9e77-1d583a5d09c2.png)

Lista todos los registros (sin parametros) [GET]http://127.0.0.1:8000/api/pictures
![Screen Shot 2022-05-11 at 15 49 09](https://user-images.githubusercontent.com/101833936/167924224-eb98d11c-26f1-424c-99be-31e825896ae0.png)

Lista solo los campos requeridos [GET]http://127.0.0.1:8000/api/pictures?fields=name,country
![Screen Shot 2022-05-11 at 15 53 49](https://user-images.githubusercontent.com/101833936/167924911-12175d49-0625-4317-a596-9642077146c0.png)

Lista solo campos requeridos y mediante filtro personalizado [GET] http://127.0.0.1:8000/api/pictures?fields=name,country&filters['painter']=gogh

![Screen Shot 2022-05-11 at 15 57 09](https://user-images.githubusercontent.com/101833936/167925383-634c6f1c-b7f2-46d0-a431-0ff394e63045.png)

Actualiza un registro [PUT] http://127.0.0.1:8000/api/pictures/1?painter=Vincent van Gogh&name=La noche estrallada&country=Estados Unidos

![Screen Shot 2022-05-11 at 16 07 27](https://user-images.githubusercontent.com/101833936/167927139-72ff0520-a3de-4437-a025-8e4577dabbb6.png)

Elimino un registro [DELETE]http://127.0.0.1:8000/api/pictures/1

![Screen Shot 2022-05-11 at 16 28 07](https://user-images.githubusercontent.com/101833936/167930356-1c6a4587-d05c-4df5-b655-6e6687a5fa54.png)

## DOCUMENTACIÓN

[https://laravel.com/docs/8.x ](https://laravel.com/docs/8.x)
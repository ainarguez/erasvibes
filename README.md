<div align="center">
  <h1>Erasvibes</h1>
</div>

<div align="center">
  <img src="public/img/logo.png" alt="Erasvibes Logo" width="300" />
  <h2>🌍 Conectando estudiantes Erasmus en tu ciudad y fechas de destino</h2>
  
  <div>
    <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
    <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
    <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
    <img src="https://img.shields.io/badge/Node.js-18.x-339933?style=for-the-badge&logo=node.js&logoColor=white" alt="Node.js" />
    <img src="https://img.shields.io/badge/Composer-2.x-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer" />
    <img src="https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white" alt="Git" />
  </div>
</div>

---

## ❓ ¿Qué es Erasvibes?

**Erasvibes** es una plataforma web diseñada para conectar estudiantes Erasmus que se encuentran en el mismo destino y periodo. Permite a los usuarios filtrar por fechas y ubicación, agregar amigos y comunicarse mediante un chat privado, promoviendo la integración social de los estudiantes.

---

## 🎯 Objetivos del Proyecto

- Facilitar la conexión de estudiantes Erasmus en la misma ciudad y fechas.
- Fomentar la integración social y el acompañamiento en un nuevo entorno.
- Ayudar en la búsqueda de alojamiento, universidades y eventos comunes.
- Crear una plataforma segura, intuitiva y amigable.

---

## 🔍 Funcionalidades Principales

- **Registro y autenticación de usuarios**: Los usuarios se registran y autentican en la plataforma para acceder a las funcionalidades.
- **Filtrado por fechas y destino**: Permite a los estudiantes buscar otros usuarios según su ciudad y periodo Erasmus.
- **Sistema de amigos**: Los usuarios pueden enviarse solicitudes de amistad y aceptar o rechazar solicitudes.
- **Chat privado**: Los usuarios pueden chatear de manera privada con los amigos que han agregado.
- **Vista de perfil**: Los usuarios pueden ver su propio perfil y el de otros.
- **Panel de administrador**: Acceso exclusivo para administradores que gestionan los usuarios.

---

## 🧰 Tecnologías Usadas

| Herramienta        | Propósito                        |
|--------------------|----------------------------------|
| Laravel            | Framework backend PHP            |
| PHP                | Lenguaje del servidor            |
| MySQL              | Base de datos relacional         |
| Bootstrap          | Framework de diseño CSS          |
| Composer           | Gestión de dependencias PHP      |
| Node.js & npm      | Compilación de assets frontend   |
| Git & GitHub       | Control de versiones             |

---

## 📚 Documentación

<div align="center">
  <a href="https://drive.google.com/drive/folders/1W2UPfxio47uYZSii2hmRdvBXqXjt85Jp?usp=sharing " target="_blank">
    <p>📚 Ver la documentación</p>
  </a>
</div>
---

## 📹 Video

<div align="center">
  <a href="https://youtu.be/0wy_rNi8s8Q " target="_blank">
    <p>🎥 Ver el video en YouTube</p>
  </a>
</div>

---

## ⚙️ Instalación del Proyecto

### Requisitos previos

- PHP >= 8.1
- Composer
- Node.js y npm
- MySQL
- Apache / Nginx
- Laravel CLI (`composer global require laravel/installer`)

### Pasos de Instalación

1. Clonar el repositorio:

```bash
git clone https://github.com/tuusuario/erasvibes.git
cd erasvibes
```

2. Instalar dependencias:

```bash
composer install
npm install && npm run build
```

3. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

4. Configurar la base de datos:
``` bash 
APP_URL=http://localhost/erasvibes/public
DB_DATABASE=erasvibes
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicación
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="Soporte Erasvibes"
MAIL_SUPPORT_ADDRESS=tu-email@gmail.com
```

5. Ejecutar migraciones:
```bash
php artisan migrate
php artisan serve
```

Acceder a http://localhost:8000